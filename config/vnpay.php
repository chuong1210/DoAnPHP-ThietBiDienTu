<?php

return [
    'vnp_TmnCode' => env('VNPAY_TMN_CODE', 'UNJVB755'),
    'vnp_HashSecret' => env('VNPAY_HASH_SECRET', 'BYUZIQWXDVNCW50TFVK5K4QVY31BEREB'),
    'vnp_Url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
    'vnp_ReturnUrl' => env('VNPAY_RETURN_URL', 'http://localhost:8000/vnpay/callback'),
    'vnp_Api' => env('VNPAY_API', 'https://sandbox.vnpayment.vn/merchant_webapi/api/transaction'),
];
