<?php
// app/Http/Controllers/Client/SupportController.php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Faq;
use App\Rules\IndisposableEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class SupportController extends Controller
{
    public function index()
    {
        $faqs = Faq::active()
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category');

        $faqs = $faqs->mapWithKeys(function ($items, $key) {
            return [$key => $items];
        })->all();

        return view('client.support.index', compact('faqs'))->with('hideSidebar', true);
    }

    public function contact(Request $request)
    {
        // === 1. HONEYPOT ===
        if ($request->filled('website')) {
            return back()->with('error', 'Yêu cầu không hợp lệ.');
        }

        // === 2. RATE LIMIT ===
        $throttleKey = 'contact|' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Quá nhiều yêu cầu. Vui lòng thử lại sau {$seconds} giây.");
        }

        // === 3. VALIDATION (KHÔNG CÓ reCAPTCHA ở đây) ===
        $validated = $request->validate([
            'name'    => 'required|string|max:60|min:2|regex:/^[\pL\s]+$/u',
            'email'   => ['required', 'email:rfc,dns', 'max:100', new IndisposableEmail],
            'phone'   => 'nullable|string|regex:/^0[0-9]{9}$/',
            'subject' => 'required|string|max:120|min:10',
            'message' => 'required|string|min:20|max:2000',
            'g-recaptcha-response' => 'required', // CHỈ check required
        ], [
            'name.required'     => 'Vui lòng nhập họ tên.',
            'name.max'          => 'Họ tên không quá 60 ký tự.',
            'name.min'          => 'Họ tên ít nhất 2 ký tự.',
            'name.regex'        => 'Họ tên chỉ chứa chữ cái và khoảng trắng.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không hợp lệ.',
            'phone.regex'       => 'Số điện thoại phải có 10 chữ số, bắt đầu bằng 0.',
            'subject.required'  => 'Vui lòng nhập tiêu đề.',
            'subject.max'       => 'Tiêu đề không quá 120 ký tự.',
            'subject.min'       => 'Tiêu đề ít nhất 10 ký tự.',
            'message.required'  => 'Vui lòng nhập nội dung.',
            'message.min'       => 'Nội dung ít nhất 20 ký tự.',
            'message.max'       => 'Nội dung không quá 2000 ký tự.',
            'g-recaptcha-response.required' => 'Vui lòng xác minh reCAPTCHA.',
        ]);

        // === 4. XÁC MINH reCAPTCHA BẰTAY ===
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secretKey = config('services.recaptcha.secret_key');

        $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip(),
        ]);

        $recaptchaData = $verifyResponse->json();

        // Check kết quả
        if (!$recaptchaData['success']) {
            return back()
                ->withInput()
                ->withErrors(['g-recaptcha-response' => 'Xác minh reCAPTCHA thất bại. Vui lòng thử lại.']);
        }

        // === 5. LÀM SẠCH DỮ LIỆU ===
        $clean = [
            'name'    => strip_tags(trim($validated['name'])),
            'email'   => filter_var($validated['email'], FILTER_SANITIZE_EMAIL),
            'phone'   => $validated['phone'] ? preg_replace('/\D/', '', $validated['phone']) : null,
            'subject' => strip_tags(trim($validated['subject'])),
            'message' => nl2br(strip_tags(trim($validated['message']))),
            'status'  => 'new',
        ];

        // === 6. LƯU DB ===
        Contact::create($clean);

        // === 7. TĂNG RATE LIMIT ===
        RateLimiter::hit($throttleKey, 3600);

        return back()->with('success', 'Cảm ơn bạn! Yêu cầu đã được gửi. Chúng tôi sẽ phản hồi trong 24h.');
    }
}
