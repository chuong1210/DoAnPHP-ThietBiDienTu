<?php

namespace App\Services;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->userRepository = $productRepository;
    }

    public function signup(RegisterRequest $request) {}
    public function signin(AuthRequest $request) {}
}
