<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleRequest extends FormRequest
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
            'code' => ['sometimes', 'required', 'string', 'size:8', 'unique:sales,code'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_doctype' => ['required', 'string', Rule::in(['DNI', 'RUC'])],
            'client_doc' => ['required', 'string', 'max:20'],
            'client_email' => ['nullable', 'email', 'unique:sales,client_email'],
            'seller_id' => ['required', 'exists:users,id'],
            'date_time' => ['sometimes', 'required', 'date_format:Y-m-d H:i:s'],
            'products' => ['required', 'array'],
            'products.*.product_id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:1'],
            'products.*.price' => ['sometimes', 'required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'El código es requerido',
            'code.size' => 'El código debe tener 8 carácteres',
            'code.unique' => 'El código debe ser único',
            'client_name.required' => 'El nombre del cliente es requerido',
            'client_name.max' => 'El nombre del cliente debe tener como máximo 255 carácteres',
            'client_doctype.required' => 'El tipo de documento del cliente es requerido',
            'client_doctype.max' => 'El tipo de documento del cliente solo puede ser DNI o RUC',
            'client_doc.required' => 'El documento del cliente es requerido',
            'client_doc.max' => 'El documento del cliente debe tener como máximo 20 carácteres',
            'client_email.required' => 'El email del cliente es requerido',
            'client_email.email' => 'El email del cliente debe ser válido',
            'client_email.unique' => 'El email del cliente debe ser único',
            'seller_id.required' => 'El vendedor es requerido',
            'seller_id.exists' => 'El vendedor no existe',
            'date_time.date_format' => 'La fecha no es válida (Y-m-d H:i:s)',
            'products.array' => 'Los productos deben ser un array',
            'products.*.product_id.required' => 'El producto es requerido',
            'products.*.product_id.exists' => 'El producto no existe',
            'products.*.quantity.required' => 'La cantidad es requerida',
            'products.*.quantity.integer' => 'La cantidad debe ser un número entero',
            'products.*.quantity.min' => 'La cantidad debe ser mayor o igual a 1',
            'products.*.price.required' => 'El precio es requerido',
            'products.*.price.numeric' => 'El precio debe ser numérico',
            'products.*.price.min' => 'La cantidad debe ser mayor o igual a 0',
        ];
    }
}
