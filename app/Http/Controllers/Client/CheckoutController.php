<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
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
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('client.cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống');
        }

        // Kiểm tra tồn kho
        foreach ($cart->items as $item) {
            if ($item->product->quantity < $item->quantity) {
                return redirect()->route('client.cart.index')
                    ->with('error', 'Sản phẩm "' . $item->product->name . '" không đủ số lượng trong kho');
            }
        }

        // Lấy thông tin user
        $user = Auth::user();

        // Lấy coupon đã áp dụng từ session (nếu có)
        $appliedCoupon = Session::get('applied_coupon');
        $discount = Session::get('discount_amount', 0);

        // Tính toán
        $subtotal = $cart->total;
        $shippingFee = 30000;
        $total = $subtotal + $shippingFee - $discount;

        return view('client.checkout.index', compact(
            'cart',
            'user',
            'subtotal',
            'shippingFee',
            'discount',
            'total',
            'appliedCoupon'
        ));
    }

    /**
     * Áp dụng mã giảm giá
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $couponCode = strtoupper(trim($request->coupon_code));

        // Tìm coupon
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Mã giảm giá không tồn tại hoặc đã hết hạn');
        }

        // Kiểm tra số lần sử dụng
        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return back()->with('error', 'Mã giảm giá đã hết lượt sử dụng');
        }

        // Lấy giỏ hàng
        $cart = Cart::where('user_id', Auth::id())->first();
        $subtotal = $cart->total;

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($subtotal < $coupon->min_order) {
            return back()->with('error', 'Đơn hàng tối thiểu ' . number_format($coupon->min_order) . 'đ để sử dụng mã này');
        }

        // Tính giảm giá
        if ($coupon->type === 'fixed') {
            $discount = $coupon->value;
        } else { // percent
            $discount = ($subtotal * $coupon->value) / 100;
        }

        // Lưu vào session
        Session::put('applied_coupon', $coupon->code);
        Session::put('discount_amount', $discount);

        return back()->with('success', 'Áp dụng mã giảm giá thành công! Bạn được giảm ' . number_format($discount) . 'đ');
    }

    /**
     * Xóa mã giảm giá
     */
    public function removeCoupon()
    {
        Session::forget(['applied_coupon', 'discount_amount']);
        return back()->with('success', 'Đã xóa mã giảm giá');
    }

    /**
     * Xử lý đặt hàng
     */
    public function process(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:15',
            'customer_email' => 'nullable|email|max:100',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,bank_transfer,momo',
            'note' => 'nullable|string|max:500',
        ], [
            'customer_name.required' => 'Họ tên không được để trống',
            'customer_phone.required' => 'Số điện thoại không được để trống',
            'shipping_address.required' => 'Địa chỉ giao hàng không được để trống',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
        ]);

        DB::beginTransaction();
        try {
            // Lấy giỏ hàng
            $cart = Cart::with(['items.product'])->where('user_id', Auth::id())->first();

            if (!$cart || $cart->items->count() === 0) {
                return redirect()->route('client.cart.index')
                    ->with('error', 'Giỏ hàng trống');
            }

            // Kiểm tra tồn kho lần cuối
            foreach ($cart->items as $item) {
                if ($item->product->quantity < $item->quantity) {
                    DB::rollBack();
                    return redirect()->route('client.cart.index')
                        ->with('error', 'Sản phẩm "' . $item->product->name . '" không đủ số lượng');
                }
            }

            // Tính toán
            $subtotal = $cart->total;
            $shippingFee = 30000;
            $discount = Session::get('discount_amount', 0);
            $total = $subtotal + $shippingFee - $discount;

            // Tạo đơn hàng
            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'shipping_address' => $validated['shipping_address'],
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

                // Tăng số lượng đã bán
                $item->product->increment('sold_count', $item->quantity);
            }

            // Cập nhật coupon usage (nếu có)
            if (Session::has('applied_coupon')) {
                $coupon = Coupon::where('code', Session::get('applied_coupon'))->first();
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            // Xóa giỏ hàng
            $cart->items()->delete();

            // Xóa session coupon
            Session::forget(['applied_coupon', 'discount_amount']);

            DB::commit();

            // TODO: Gửi email xác nhận đơn hàng
            // Mail::to($order->customer_email)->send(new OrderConfirmation($order));

            return redirect()->route('client.checkout.success', $order->id)
                ->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
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
        $orders = Order::with(['items'])
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

    /**
     * Hủy đơn hàng
     */
    public function cancelOrder(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Chỉ cho phép hủy đơn pending hoặc confirmed
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Không thể hủy đơn hàng này');
        }

        DB::beginTransaction();
        try {
            // Cập nhật trạng thái
            $order->status = 'cancelled';
            $order->save();

            // Hoàn lại số lượng tồn kho
            foreach ($order->items as $item) {
                $item->product->increment('quantity', $item->quantity);
                $item->product->decrement('sold_count', $item->quantity);
            }

            DB::commit();

            return back()->with('success', 'Đã hủy đơn hàng thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Tạo mã đơn hàng
     */
    private function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}
