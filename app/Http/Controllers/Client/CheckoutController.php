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
use Illuminate\Support\Facades\Log;
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
        $couponSession = session('coupon');
        $discount = 0;

        if ($couponSession) {
            $discount = $couponSession['discount'];
        }

        // Tổng tiền cuối cùng (đã trừ giảm giá + phí ship)
        $shippingFee = 30000;
        $totalAfterDiscount = $cart->total + $shippingFee - $discount;

        return view('client.checkout.index', compact('cart', 'availablecoupons', 'categories', 'coupons',  'totalAfterDiscount'));
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
    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Đã xóa mã giảm giá');
    }
    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string|max:50']);

        $code = strtoupper(trim($request->code));

        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không tồn tại',
            ], 422);
        }

        // Kiểm tra thời hạn
        $now = now();
        if ($coupon->start_date && $now->lt($coupon->start_date)) {
            return response()->json(['success' => false, 'message' => 'Mã chưa đến thời gian sử dụng'], 422);
        }
        if ($coupon->end_date && $now->gt($coupon->end_date)) {
            return response()->json(['success' => false, 'message' => 'Mã đã hết hạn'], 422);
        }

        // Kiểm tra lượt dùng
        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return response()->json(['success' => false, 'message' => 'Mã đã hết lượt'], 422);
        }

        // Lấy giỏ hàng
        $cart = Cart::with('items')->where('user_id', Auth::id())->firstOrFail();
        $subtotal = $cart->total;

        if ($subtotal < $coupon->min_order) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn tối thiểu ' . number_format($coupon->min_order) . 'đ',
            ], 422);
        }

        $discount = $coupon->calculateDiscount($subtotal);
        if ($discount <= 0) {
            return response()->json(['success' => false, 'message' => 'Không áp dụng được'], 422);
        }

        // LƯU VÀO SESSION (không increment used_count)
        session([
            'coupon' => [
                'id'        => $coupon->id,
                'code'      => $coupon->code,
                'discount'  => $discount,
                'type'      => $coupon->type,
                'value'     => $coupon->value,
            ]
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Áp dụng thành công!',
            'discount'   => number_format($discount),
            'new_total'  => number_format($subtotal + 30000 - $discount),
        ]);
    }
    /**
     * Xử lý đặt hàng
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'customer_name'     => 'required|string|max:100',
            'customer_phone'    => 'required|string|max:15',
            'customer_email'    => 'nullable|email',
            'shipping_address'  => 'required|string',
            'shipping_province' => 'required',
            'shipping_ward'     => 'required|string',
            'payment_method'    => 'required|in:cod,bank_transfer,momo,vnpay',
            'note'              => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $cart = Cart::with('items.product')->where('user_id', Auth::id())->firstOrFail();
            if ($cart->items->isEmpty()) {
                return back()->with('error', 'Giỏ hàng trống');
            }

            // === KIỂM TRA TỒN KHO ===
            foreach ($cart->items as $item) {
                if ($item->product->quantity < $item->quantity) {
                    DB::rollBack();
                    return back()->with('error', "Sản phẩm {$item->product->name} không đủ hàng");
                }
            }

            $subtotal    = $cart->total;
            $shippingFee = 30000;
            $discount    = 0;
            $couponId    = null;

            // === ĐỌC COUPON TỪ SESSION ===
            if (session()->has('coupon')) {
                $couponData = session('coupon');
                $coupon = Coupon::find($couponData['id']);

                // Kiểm tra lại coupon còn hợp lệ không
                if ($coupon && $coupon->is_active && $subtotal >= $coupon->min_order) {
                    $discount = $couponData['discount'];
                    $couponId = $coupon->id;
                } else {
                    // Coupon không hợp lệ → xóa session
                    session()->forget('coupon');
                }
            }

            $total = $subtotal + $shippingFee - $discount;

            // === TẠO ORDER ===
            $order = Order::create([
                'order_number'     => 'ORD-' . strtoupper(uniqid()),
                'user_id'          => Auth::id(),
                'coupon_id'        => $couponId,
                'customer_name'    => $validated['customer_name'],
                'customer_phone'   => $validated['customer_phone'],
                'customer_email'   => $validated['customer_email'],
                'shipping_address' => $validated['shipping_address'] . ', ' .
                    $validated['shipping_ward'] . ', ' .
                    $validated['shipping_province'],
                'shipping_ward'    => $validated['shipping_ward'],
                'shipping_city'    => $validated['shipping_province'],
                'subtotal'         => $subtotal,
                'shipping_fee'     => $shippingFee,
                'discount'         => $discount,
                'total'            => $total,
                'payment_method'   => $validated['payment_method'],
                'payment_status'   => 'pending',
                'status'           => 'pending',
                'note'             => $validated['note'] ?? null,
            ]);

            // === CHI TIẾT + GIẢM TỒN KHO ===
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item->product_id,
                    'product_name'  => $item->product->name,
                    'product_image' => $item->product->image,
                    'price'         => $item->price,
                    'quantity'      => $item->quantity,
                    'subtotal'      => $item->subtotal,
                ]);

                $item->product->decrement('quantity', $item->quantity);
                $item->product->increment('sold_count', $item->quantity);
            }

            // === TĂNG used_count CHỈ KHI THÀNH CÔNG ===
            if ($couponId) {
                Coupon::where('id', $couponId)->increment('used_count');
            }

            // === XÓA SESSION + GIỎ HÀNG ===
            session()->forget('coupon');
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('client.checkout.success', $order->id)
                ->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    /**
     * Trang đặt hàng thành công
     */
    public function success($orderId, CategoryRepository $categoryRepository)
    {
        $order = Order::with(['items.product', 'user'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $categories = $categoryRepository->getSidebarCategories();

        return view('client.checkout.success', compact('order', 'categories'));
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
