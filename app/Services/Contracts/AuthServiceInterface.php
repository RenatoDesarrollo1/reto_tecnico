<?php

namespace App\Services\Contracts;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

interface AuthServiceInterface
{
    public function login(LoginRequest $request);
    public function register(RegisterRequest $request);
    public function logout();
}
