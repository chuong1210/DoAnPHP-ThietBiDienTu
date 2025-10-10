<?php

namespace App\Services\Interfaces;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;

interface UserServiceInterface
{
    public function signup(RegisterRequest $request);
    public function signin(AuthRequest $request);
}
