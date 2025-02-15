<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
    public function rules()
    {
        return [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'seller'])],
        ];
    }

    public function messages()
    {
        return [
            'fname.required' => 'El nombre es requerido',
            'fname.max' => 'El nombre debe tener como máximo 255 carácteres',
            'lname.required' => 'El apellido es requerido',
            'lname.max' => 'El apellido debe tener como máximo 255 carácteres',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe ser valido',
            'email.unique' => 'El email debe ser único',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener como minimo 6 carácteres',
            'password.confirmed' => 'Por favor, confirme la contraseña',
            'role.required' => 'El rol es requerido',
            'role.in' => 'El rol solo debe ser admin (Administrador) o seller (Vendedor)',

        ];
    }
}
