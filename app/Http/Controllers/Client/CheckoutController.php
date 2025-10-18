<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Repositories\CategoryRepository;
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
    public function index(CategoryRepository $categoryRepository)
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

        // Lấy danh sách coupon khả dụng
        $availablecoupons = Coupon::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where(function ($query) {
                $query->whereNull('max_uses')
                    ->orWhereRaw('used_count < max_uses');
            })
            ->orderBy('value', 'DESC')
            ->get();
        $coupons = Coupon::active()->get(); // Load active coupons

        $categories = $categoryRepository->getSidebarCategories();
        return view('client.checkout.index', compact('cart', 'availablecoupons', 'categories', 'coupons'));
    }

    /**
     * Áp dụng coupon (AJAX)
     */

    // public function applyCoupon(Request $request)
    // {
    //     $request->validate(['code' => 'required|string']);

    //     $coupon = Coupon::where('code', $request->code)->first();

    //     if (!$coupon || !$coupon->isValid()) {
    //         return back()->withErrors(['code' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn']);
    //     }

    //     // Tính discount dựa trên cart total (giả sử session('cart') hoặc query)
    //     $cartTotal = session('cart_total', 0); // Hoặc từ cart model
    //     $discount = $coupon->calculateDiscount($cartTotal);

    //     if ($discount > 0) {
    //         session(['coupon' => ['code' => $coupon->code, 'discount' => $discount]]);
    //         $coupon->incrementUsage();
    //         return back()->with('success', 'Áp dụng mã giảm giá thành công! Giảm ' . number_format($discount) . 'đ');
    //     }

    //     return back()->withErrors(['code' => 'Mã giảm giá không áp dụng được cho đơn hàng này']);
    // }
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);
        // return back()->with('success', 'Áp dụng mã giảm giá thành công! Giảm ' . number_format($discount) . 'đ');
        // return back()->withErrors(['code' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn']);

        $code = strtoupper(trim($request->code)); // Trim space

        // Tìm coupon (case-insensitive nếu cần: whereRaw('UPPER(code) = ?', [$code]))
        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không tồn tại hoặc không hợp lệ',
            ], 422); // HTTP 422 for validation error
        }

        // Kiểm tra thời hạn (sử dụng Carbon để so sánh trực tiếp)
        if ($coupon->start_date && Carbon::parse($coupon->start_date)->isFuture()) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá chưa đến thời gian sử dụng',
            ], 422);
        }

        if ($coupon->end_date && Carbon::parse($coupon->end_date)->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đã hết hạn',
            ], 422);
        }

        // Kiểm tra số lần sử dụng
        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đã hết lượt sử dụng',
            ], 422);
        }

        // Lấy giỏ hàng và subtotal
        $cart = Cart::with('items')->where('user_id', Auth::id())->first();
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng trống',
            ], 422);
        }

        $subtotal = $cart->total; // Giả sử accessor total = sum(items->subtotal)

        // Kiểm tra min_order
        if ($subtotal < $coupon->min_order) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng phải đạt tối thiểu ' . number_format($coupon->min_order) . 'đ để áp dụng mã này',
            ], 422);
        }

        // Tính discount (sử dụng method trong model nếu có)
        $discount = $coupon->calculateDiscount($subtotal); // Hoặc logic như cũ

        if ($discount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không áp dụng được giảm giá cho đơn hàng này',
            ], 422);
        }

        // Tăng usage count
        $coupon->increment('used_count');

        // Lưu vào session (để dùng ở checkout/cart summary)
        session([
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount' => $discount,
                'type' => $coupon->type,
                'value' => $coupon->value,
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount' => number_format($discount),
            'new_total' => number_format($subtotal + 30000 - $discount), // + shipping - discount
            'coupon' => [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
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
            'applied_coupon_code' => 'nullable|string',
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

            // Xử lý coupon nếu có
            if ($request->applied_coupon_code) {
                $coupon = Coupon::where('code', $request->applied_coupon_code)
                    ->where('is_active', true)
                    ->first();

                if ($coupon && $coupon->isValid() && $subtotal >= $coupon->min_order) {
                    $discount = $coupon->calculateDiscount($subtotal);
                    $couponId = $coupon->id;
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

            // Tăng số lần sử dụng coupon
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
