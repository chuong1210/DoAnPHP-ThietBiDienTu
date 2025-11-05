<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VnpayController extends Controller
{
    public function callback(Request $request)
    {
        // Lấy tất cả tham số VNPAY trả về
        $vnp_Params = $request->all();

        // Lấy hash secret từ config
        $vnp_HashSecret = config('services.vnpay.hash_secret');

        // Lấy vnp_SecureHash từ URL
        $vnp_SecureHash = $vnp_Params['vnp_SecureHash'];

        // Loại bỏ vnp_SecureHash và vnp_SecureHashType khỏi mảng dữ liệu
        unset($vnp_Params['vnp_SecureHashType']);
        unset($vnp_Params['vnp_SecureHash']);

        // Sắp xếp dữ liệu theo key
        ksort($vnp_Params);

        // Tạo chuỗi hash
        $hashData = "";
        $i = 0;
        foreach ($vnp_Params as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        // Tạo chữ ký bảo mật mới
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // Lấy mã đơn hàng
        $orderId = $vnp_Params['vnp_TxnRef'];

        try {
            // So sánh chữ ký để đảm bảo dữ liệu không bị thay đổi
            if ($secureHash == $vnp_SecureHash) {
                // Tìm đơn hàng trong DB
                $order = Order::where('order_number', $orderId)->first();

                if ($order) {
                    // Kiểm tra xem đơn hàng đã được xử lý chưa
                    if ($order->payment_status == 'pending') {
                        // Kiểm tra mã phản hồi từ VNPAY
                        if ($vnp_Params['vnp_ResponseCode'] == '00' && $vnp_Params['vnp_TransactionStatus'] == '00') {
                            // THANH TOÁN THÀNH CÔNG
                            $order->payment_status = 'paid'; // Cập nhật trạng thái thanh toán
                            $order->status = 'confirmed';   // Cập nhật trạng thái đơn hàng
                            $order->save();

                            // (Tùy chọn) Gửi email xác nhận thanh toán thành công
                            // Mail::to($order->customer_email)->send(new PaymentSuccessMail($order));

                            // Chuyển hướng đến trang thành công
                            return redirect()->route('client.checkout.success', $order->id)
                                ->with('success', 'Thanh toán đơn hàng thành công!');
                        } else {
                            // THANH TOÁN THẤT BẠI
                            $order->status = 'cancelled';
                            $order->payment_status = 'failed';
                            $order->save();

                            // (Tùy chọn) Khôi phục lại số lượng sản phẩm
                            // ...

                            return redirect()->route('client.checkout.index')
                                ->with('error', 'Thanh toán không thành công. Vui lòng thử lại.');
                        }
                    }
                    // Nếu đơn hàng đã được xử lý (paid), chuyển hướng đến trang thành công
                    return redirect()->route('client.checkout.success', $order->id);
                } else {
                    return redirect()->route('client.home.index')->with('error', 'Không tìm thấy đơn hàng.');
                }
            } else {
                Log::error('VNPAY Callback: Invalid signature.');
                return redirect()->route('client.home.index')->with('error', 'Chữ ký không hợp lệ.');
            }
        } catch (\Exception $e) {
            Log::error('VNPAY Callback Error: ' . $e->getMessage());
            return redirect()->route('client.home.index')->with('error', 'Đã có lỗi xảy ra trong quá trình xử lý.');
        }
    }
}
