<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest
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
            'sku' => ['sometimes', 'required', 'string', 'size:7', 'unique:products,sku'],
            'name' => ['required', 'string', 'max:255'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'sku.required' => "El sku es requerido",
            'sku.size' => "El sku debe tener 7 carácteres",
            'sku.unique' => "El sku debe ser único",
            'name.required' => "El nombre es requerido",
            'name.max' => "El nombre debe tener como máximo 255 carácteres",
            'unit_price.required' => "El precio es requerido",
            'unit_price.numeric' => "El precio debe ser numérico",
            'unit_price.min' => "El precio debe ser mayor o igual a 0",
            'stock.required' => "El stock es requerido",
            'stock.integer' => "El stock debe ser numérico entero",
            'stock.min' => "El stock debe ser mayor o igual a 0",
        ];
    }
}
