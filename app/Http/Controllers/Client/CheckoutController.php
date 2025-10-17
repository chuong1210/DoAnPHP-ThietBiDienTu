<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * @param \App\Http\Requests\AuthRequest $authRequest
 */

class CheckoutController extends Controller
{

    /**
     * Hiển thị trang checkout
     */
    public function index()
    {
        $cart = Cart::with(['items.product.brand'])
            ->where('user_id', Auth::id())
            ->first();

        // Kiểm tra giỏ hàng
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('client.cart.index')
                ->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán');
        }

        // Kiểm tra tồn kho
        foreach ($cart->items as $item) {
            if ($item->product->quantity < $item->quantity) {
                return redirect()->route('client.cart.index')
                    ->with('error', 'Sản phẩm "' . $item->product->name . '" không đủ số lượng trong kho');
            }
        }

        // Lấy danh sách voucher khả dụng
        $availableVouchers = Coupon::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where(function ($query) {
                $query->whereNull('max_uses')
                    ->orWhereRaw('used_count < max_uses');
            })
            ->orderBy('value', 'DESC')
            ->get();

        return view('client.checkout.index', compact('cart', 'availableVouchers'));
    }

    /**
     * Áp dụng voucher (AJAX)
     */
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = strtoupper($request->code);

        // Tìm voucher
        $voucher = Coupon::where('code', $code)
            ->where('is_active', true)
            ->first();

        // Kiểm tra voucher
        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không tồn tại'
            ]);
        }

        // Kiểm tra thời hạn
        if (Carbon::parse($voucher->start_date)->isFuture()) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá chưa đến thời gian sử dụng'
            ]);
        }

        if (Carbon::parse($voucher->end_date)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đã hết hạn'
            ]);
        }

        // Kiểm tra số lần sử dụng
        if ($voucher->max_uses && $voucher->used_count >= $voucher->max_uses) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đã hết lượt sử dụng'
            ]);
        }

        // Lấy giỏ hàng
        $cart = Cart::with('items')->where('user_id', Auth::id())->first();
        $subtotal = $cart->total;

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($subtotal < $voucher->min_order) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng tối thiểu ' . number_format($voucher->min_order) . 'đ để áp dụng mã này'
            ]);
        }

        // Tính giảm giá
        $discount = 0;
        if ($voucher->type === 'fixed') {
            $discount = $voucher->value;
        } else { // percent
            $discount = ($subtotal * $voucher->value) / 100;

            // Áp dụng giảm giá tối đa
            if ($voucher->max_discount && $discount > $voucher->max_discount) {
                $discount = $voucher->max_discount;
            }
        }

        // Đảm bảo discount không vượt quá tổng tiền
        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'voucher' => [
                'code' => $voucher->code,
                'type' => $voucher->type,
                'value' => $voucher->value,
            ]
        ]);
    }

    /**
     * Xử lý đặt hàng
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:15',
            'customer_email' => 'nullable|email|max:100',
            'shipping_address' => 'required|string',
            'shipping_ward' => 'required|string|max:100',
            'shipping_district' => 'required|string|max:100',
            'shipping_city' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,bank_transfer,momo',
            'note' => 'nullable|string',
            'applied_voucher_code' => 'nullable|string',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ nhận hàng',
            'shipping_ward.required' => 'Vui lòng nhập phường/xã',
            'shipping_district.required' => 'Vui lòng nhập quận/huyện',
            'shipping_city.required' => 'Vui lòng nhập tỉnh/thành phố',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
        ]);

        DB::beginTransaction();
        try {
            // Lấy giỏ hàng
            $cart = Cart::with(['items.product'])->where('user_id', Auth::id())->first();

            if (!$cart || $cart->items->count() == 0) {
                return redirect()->route('client.cart.index')
                    ->with('error', 'Giỏ hàng trống');
            }

            // Kiểm tra tồn kho lần cuối
            foreach ($cart->items as $item) {
                if ($item->product->quantity < $item->quantity) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'Sản phẩm "' . $item->product->name . '" không đủ số lượng trong kho')
                        ->withInput();
                }
            }

            $subtotal = $cart->total;
            $shippingFee = 30000;
            $discount = 0;
            $couponId = null;

            // Xử lý voucher nếu có
            if ($request->applied_voucher_code) {
                $voucher = Coupon::where('code', $request->applied_voucher_code)
                    ->where('is_active', true)
                    ->first();

                if ($voucher && $voucher->isValid() && $subtotal >= $voucher->min_order) {
                    $discount = $voucher->calculateDiscount($subtotal);
                    $couponId = $voucher->id;
                }
            }

            $total = $subtotal + $shippingFee - $discount;

            // Tạo đơn hàng
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => Auth::id(),
                'coupon_id' => $couponId,
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'shipping_address' => $validated['shipping_address'] . ', ' .
                    $validated['shipping_ward'] . ', ' .
                    $validated['shipping_district'] . ', ' .
                    $validated['shipping_city'],
                'shipping_ward' => $validated['shipping_ward'],
                'shipping_district' => $validated['shipping_district'],
                'shipping_city' => $validated['shipping_city'],
                'subtotal' => $subtotal,
                'shipping_fee' => $shippingFee,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'status' => 'pending',
                'note' => $validated['note'],
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_image' => $item->product->image,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);

                // Giảm số lượng tồn kho
                $item->product->decrement('quantity', $item->quantity);
                $item->product->increment('sold_count', $item->quantity);
            }

            // Tăng số lần sử dụng voucher
            if ($couponId) {
                Coupon::find($couponId)->increment('used_count');
            }

            // Xóa giỏ hàng
            $cart->items()->delete();

            DB::commit();

            // TODO: Gửi email xác nhận (optional)
            // Mail::to($order->customer_email)->send(new OrderConfirmation($order));

            return redirect()->route('client.checkout.success', $order->id)
                ->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Trang đặt hàng thành công
     */
    public function success($orderId)
    {
        $order = Order::with(['items.product', 'user'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('client.checkout.success', compact('order'));
    }

    /**
     * Danh sách đơn hàng của tôi
     */
    public function myOrders()
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('client.orders.index', compact('orders'));
    }

    /**
     * Chi tiết đơn hàng
     */
    public function orderDetail($orderId)
    {
        $order = Order::with(['items.product'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('client.orders.detail', compact('order'));
    }
}
