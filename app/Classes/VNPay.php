<?php

namespace App\Classes;

use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class VNPay
{
    // app/Classes/VNPay.php
    public function payment($totalPrice, $orderCode)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $config = config('vnpay');
        $vnp_TmnCode = $config['vnp_TmnCode'];
        $vnp_HashSecret = $config['vnp_HashSecret'];
        $vnp_Url = $config['vnp_Url'];
        $vnp_Returnurl = $config['vnp_ReturnUrl'];

        $vnp_TxnRef = $orderCode;
        $vnp_OrderInfo = "Thanh toan don hang #$orderCode";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = (int)($totalPrice * 100);
        $vnp_Locale = "vn";
        $vnp_IpAddr = request()->ip();
        $vnp_CreateDate = now('Asia/Ho_Chi_Minh')->format('YmdHis');
        $vnp_ExpireDate = now('Asia/Ho_Chi_Minh')->addMinutes(15)->format('YmdHis');

        $inputData = [
            "vnp_Version"     => "2.1.0",
            "vnp_Command"     => "pay",
            "vnp_TmnCode"     => $vnp_TmnCode,
            "vnp_Amount"      => $vnp_Amount,
            "vnp_CreateDate"  => $vnp_CreateDate,
            "vnp_CurrCode"    => "VND",
            "vnp_ExpireDate"  => $vnp_ExpireDate,
            "vnp_IpAddr"      => $vnp_IpAddr,
            "vnp_Locale"      => $vnp_Locale,
            "vnp_OrderInfo"   => $vnp_OrderInfo,
            "vnp_OrderType"   => $vnp_OrderType,
            "vnp_ReturnUrl"   => $vnp_Returnurl,
            "vnp_TxnRef"      => $vnp_TxnRef,
        ];

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);

        $hashdata = "";
        $query = "";
        $first = true;

        foreach ($inputData as $key => $value) {
            $encodedKey = rawurlencode($key);
            $encodedValue = rawurlencode($value);

            // CHỈ THAY %20 → + TRONG HASHDATA
            $hashValue = str_replace('%20', '+', $encodedValue);

            if (!$first) {
                $hashdata .= '&';
                $query .= '&';
            }
            $hashdata .= $encodedKey . "=" . $hashValue;
            $query .= $encodedKey . "=" . $encodedValue;
            $first = false;
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url = $vnp_Url . "?" . $query . "&vnp_SecureHash=" . $vnpSecureHash;

        Log::info('VNPay Hash Fix', [
            'hashdata' => $hashdata,
            'query' => $query,
            'hash' => $vnpSecureHash
        ]);

        Log::info('VNPay url', [
            'url' => $vnp_Url

        ]);

        return [
            'errorCode' => 0,
            'message' => 'success',
            'url' => $vnp_Url
        ];
    }
}
