<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VnpayController extends Controller
{
    // app/Http/Controllers/Client/VnpayController.php

    public function callback(Request $request)
    {
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $inputData = [];
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);
        $hashData = "";
        $first = true;
        foreach ($inputData as $key => $value) {
            $encodedKey = rawurlencode($key);
            $encodedValue = rawurlencode($value);
            $hashValue = str_replace('%20', '+', $encodedValue);

            if (!$first) $hashData .= '&';
            $hashData .= $encodedKey . "=" . $hashValue;
            $first = false;
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        Log::info('VNPay Return Hash', [
            'received' => $vnp_SecureHash,
            'calculated' => $secureHash,
            'match' => $secureHash === $vnp_SecureHash,
            'hashData' => $hashData
        ]);

        if ($secureHash === $vnp_SecureHash && $inputData['vnp_ResponseCode'] == '00') {
            return redirect()->route('client.checkout.success')
                ->with('success', 'Thanh toán VNPay thành công!');
        }

        return redirect()->route('client.cart.index')
            ->with('error', 'Thanh toán thất bại hoặc chữ ký không hợp lệ');
    }

    // Helper: Dịch mã lỗi VNPay
    private function getVnpayErrorMessage($code)
    {
        $messages = [
            '07' => 'Giao dịch bị nghi ngờ gian lận',
            '09' => 'Thẻ/tài khoản chưa đăng ký Internet Banking',
            '10' => 'Xác thực sai quá 3 lần',
            '11' => 'Hết hạn thanh toán',
            '12' => 'Thẻ/tài khoản bị khóa',
            '13' => 'Sai OTP',
            '24' => 'Khách hàng hủy giao dịch',
            '51' => 'Tài khoản không đủ tiền',
            '65' => 'Vượt hạn mức giao dịch',
            '75' => 'Ngân hàng đang bảo trì',
            '79' => 'Nhập sai mật khẩu quá số lần',
            '99' => 'Lỗi không xác định',
            '00' => 'Thành công',
            '01' => 'Giao dịch đã tồn tại',
            '02' => 'Merchant không hợp lệ',
            '03' => 'Dữ liệu gửi sang không đúng định dạng',
            '04' => 'Khởi tạo giao dịch không thành công do thẻ/tài khoản bị khóa',
            '05' => 'Giao dịch không thành công do: Tài khoản không tồn tại',
            '06' => 'Giao dịch không thành công do: Tài khoản không đủ số dư',


        ];

        return $messages[$code] ?? "Mã lỗi: $code";
    }
    /**
     * Lấy thông báo lỗi VNPay
     */
}
