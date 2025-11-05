<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterWelcome;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ'
        ]);

        $email = $request->email;

        // Gửi email chào mừng
        try {
            Mail::to($email)->send(new NewsletterWelcome($email));
        } catch (\Exception $e) {
            Log::error('Newsletter mail failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gửi email thất bại. Vui lòng thử lại!'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cảm ơn bạn! Email chào mừng đã được gửi.'
        ]);
    }
}
