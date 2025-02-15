<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Contracts\AuthServiceInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceInterface
{
    public function login(LoginRequest $request)
    {
        $key = $request->getRateLimiterKey();
        $decayMinutes = 1;

        if ($request->ensureIsNotRateLimited()) {
            throw new \Exception('Muchos intentos, por favor volverlo a intentar en ' . RateLimiter::availableIn($key) . ' segundos.', JsonResponse::HTTP_TOO_MANY_REQUESTS);
        }


        $remember = $request->get('remember_me', false);

        if (!$token = auth()->attempt(["email" => $request?->email, "password" => $request?->password])) {
            RatelIMITER::hit($key, $decayMinutes * 60);

            throw new \Exception('Credenciales inválidas', JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($remember) {
            Auth::setTTL(60 * 24 * 7);
        }

        RateLimiter::clear($key);

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }

    public function register(RegisterRequest $request)
    {

        $user = User::create([...$request->except(["role"]), 'password' => Hash::make($request?->password)]);

        $user->assignRole($request->role);

        return $user;
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        auth()->logout();
    }
}
