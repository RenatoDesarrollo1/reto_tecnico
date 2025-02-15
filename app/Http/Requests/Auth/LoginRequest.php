<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => ["required", "exists:users,email"],
            "password" =>  ["required", "string"],
            "remember_me" => ["boolean"]
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "El email es requerido",
            "email.exists" => "El email no existe",
            "password.required" => "La contraseña es requerida",
        ];
    }


    public function ensureIsNotRateLimited()
    {
        $key = $this->getRateLimiterKey();
        $maxAttempts = 5;

        return RateLimiter::tooManyAttempts($key, $maxAttempts);
    }

    public function getRateLimiterKey()
    {
        return Str::lower($this->input('email')) . '|' . $this->ip();
    }
}
