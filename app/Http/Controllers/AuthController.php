<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function showVerificationNotice()
    {
        return view('auth.verify');
    }

    /**
     * Xử lý yêu cầu xác thực email (khi người dùng click vào link).
     */
    // public function verifyEmail(EmailVerificationRequest $request)
    // {
    //     $request->fulfill();

    //     return redirect()->route('client.home.index')->with('success', 'Email của bạn đã được xác thực thành công!');
    // }

    public function verifyEmail(Request $request) // <-- Thay đổi ở đây
    {
        // Tìm người dùng dựa trên ID trong URL
        $user = User::find($request->route('id'));

        // Kiểm tra xem người dùng có tồn tại và email đã được xác thực chưa
        if (! $user || $user->hasVerifiedEmail()) {
            // Nếu đã xác thực hoặc không tìm thấy user, chuyển hướng đến login
            return redirect()->route('login')->with('info', 'Tài khoản không tồn tại hoặc đã được xác thực.');
        }

        // Kiểm tra chữ ký của URL (rất quan trọng để bảo mật)
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            // Chữ ký không hợp lệ, từ chối yêu cầu
            return redirect()->route('login')->with('error', 'Liên kết xác thực không hợp lệ.');
        }

        // Đánh dấu email đã được xác thực
        if ($user->markEmailAsVerified()) {
            // Kích hoạt sự kiện Verified
            event(new \Illuminate\Auth\Events\Verified($user));
        }

        // (Tùy chọn) Tự động đăng nhập cho người dùng
        Auth::login($user);

        // Chuyển hướng đến trang chủ với thông báo thành công
        return redirect()->route('client.home.index')->with('success', 'Email của bạn đã được xác thực thành công!');
    }

    /**
     * Gửi lại email xác thực.
     */
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('client.home.index');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.');
    }
    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        // Validate
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
        ]);

        // Kiểm tra "Remember Me"
        $remember = $request->has('remember');

        // Thử đăng nhập
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Kiểm tra role và redirect
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Đăng nhập thành công!');
            }

            return redirect()->route('client.home.index')
                ->with('success', 'Đăng nhập thành công!');
        }

        // Đăng nhập thất bại
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }
    /**
     * Redirect to Google login
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }




    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->getId())->orWhere('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update avatar nếu thay đổi
                if ($user->avatar !== $googleUser->getAvatar()) {
                    $user->avatar = $googleUser->getAvatar();
                    $user->save();
                }

                Auth::login($user);
                return redirect()->route('client.home.index')
                    ->with('success', 'đăng nhập bằng Google thành công!');
                // Redirect dựa trên role...
            } else {
                // Tạo user mới
                $user = User::create([
                    'full_name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'role' => 'user',
                    'status' => 'active',
                    // Không set password cho Google user
                ]);

                Auth::login($user);
                return redirect()->route('client.home.index')
                    ->with('success', 'Tạo tài khoản và đăng nhập bằng Google thành công!');
            }
        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Lỗi đăng nhập Google: ' . $e->getMessage());
        }
    }


    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:15',
            'password' => 'required|confirmed|min:8',
            // THÊM VALIDATION CHO RECAPTCHA
            'g-recaptcha-response.required' => 'Vui lòng xác minh reCAPTCHA.',

        ], [
            'full_name.required' => 'Họ tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
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
        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'status' => 'active',
        ]);

        // Auth::login($user);
        $user->sendEmailVerificationNotification();

        // Chuyển hướng đến trang đăng nhập với thông báo
        return redirect()->route('login')
            ->with('success', 'Đăng ký thành công! Vui lòng email của bạn để xác thực tài khoản.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.home.index')
            ->with('success', 'Đã đăng xuất thành công!');
    }

    /**
     * Hiển thị trang profile
     */
    public function profile(CategoryRepository $categoryRepository)
    {
        $user = Auth::user();
        $categories = $categoryRepository->getSidebarCategories(); // Pass categories for layout sidebar

        return view('client.profile.index', compact('user', 'categories'));
    }

    /**
     * Cập nhật profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:15',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'full_name.required' => 'Họ tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'current_password.required_with' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp',
        ]);

        // Cập nhật thông tin cơ bản
        $user->full_name = $validated['full_name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        // Nếu đổi mật khẩu
        // Nếu đổi mật khẩu
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
            }

            // Gán new_password (mutator sẽ hash tự động)
            $user->new_password = $validated['new_password']; // Sử dụng field tạm, mutator setPasswordAttribute sẽ handle
        }

        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }


    /**
     * Cập nhật mật khẩu
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ], [
            'current_password.required' => 'Mật khẩu hiện tại không được để trống',
            'password.required' => 'Mật khẩu mới không được để trống',
            'password.confirmed' => 'Xác nhận mật khẩu mới không khớp',
            'password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'password.mixed' => 'Mật khẩu mới phải có ít nhất 1 chữ hoa và 1 chữ thường',
            'password.numbers' => 'Mật khẩu mới phải có ít nhất 1 số',
        ]);

        $user = Auth::user();
        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
        }

        // Gán password mới (mutator sẽ hash)
        $user->fill(['password' => $request->password]);
        // $user->setPasswordAttribute($request->password);

        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
