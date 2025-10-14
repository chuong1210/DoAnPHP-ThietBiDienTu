<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
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
        ], [
            'full_name.required' => 'Họ tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ]);

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'status' => 'active',
        ]);

        Auth::login($user);

        return redirect()->route('client.home.index')
            ->with('success', 'Đăng ký thành công!');
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
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác']);
            }

            $user->password = Hash::make($request->new_password);
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

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
