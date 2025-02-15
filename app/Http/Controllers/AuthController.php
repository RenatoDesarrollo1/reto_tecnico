<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request);

        return $this->responseSuccess($data, "Usuario autenticado correctamente", JsonResponse::HTTP_OK);
    }

    public function register(RegisterRequest $request)
    {
        $data = $this->authService->register($request);

        return $this->responseSuccess($data, "Usuario registrado correctamente", JsonResponse::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $data = $this->authService->logout();

        return $this->responseSuccess($data, "Usuario cerro sesión correctamente", JsonResponse::HTTP_OK);
    }
}
