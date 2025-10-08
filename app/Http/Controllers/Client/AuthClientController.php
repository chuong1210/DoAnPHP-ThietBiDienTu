<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\clientController;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @param \App\Http\Requests\AuthRequest $authRequest
 */
class AuthClientController extends clientController
{
    protected $customerService;
    public function __construct(CustomerService $customerService)
    {
        parent::__construct();
        $this->customerService = $customerService;
    }

    public function index()
    {
        $system = $this->system;
        return view('client.auth.login', compact('system'));
    }

    public function login(AuthRequest $authRequest)
    {
        /** @var \Illuminate\Http\Request $authRequest */
        $credentials = [
            'email' => $authRequest->input('email'),
            'password' => $authRequest->input('password')
        ];

        // Thực hiện đăng nhập
        if (Auth::guard('customers')->attempt($credentials)) {
            flash()->success(__('toast.login_success'));
            return redirect()->route('home.index');
        }

        flash()->error(__('toast.login_failed'));
        return redirect()->route('authClient.index');
    }

    public function register()
    {
        $system = $this->system;
        return view('client.auth.register', compact('system'));
    }

    public function signup(RegisterRequest $registerRequest)
    {
        if ($this->customerService->signup($registerRequest)) {
            flash()->success(__('toast.store_success'));
            return redirect()->route('authClient.index');
        }
        flash()->error(__('toast.store_failed'));
        return redirect()->route('authClient.register');
    }

    public function logout(Request $request)
    {
        Auth::guard('customers')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home.index');
    }
}
