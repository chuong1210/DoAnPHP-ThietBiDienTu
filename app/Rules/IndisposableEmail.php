<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class IndisposableEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $domain = substr(strrchr($value, "@"), 1);

        // Cache 1 ngày
        $cacheKey = 'disposable_email_' . md5($domain);
        $isDisposable = cache()->remember($cacheKey, 86400, function () use ($domain) {
            try {
                $response = Http::timeout(5)->get("https://open.kickbox.com/v1/disposable/{$domain}");
                return $response->successful() && $response->json('disposable') === true;
            } catch (\Exception $e) {
                return false; // Không chặn nếu API lỗi
            }
        });

        if ($isDisposable) {
            $fail('Vui lòng sử dụng email thật, không dùng email tạm như :domain.', ['domain' => $domain]);
        }
    }
}
