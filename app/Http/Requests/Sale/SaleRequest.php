<?php

namespace App\Http\Requests\Sale;

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
            'start_date' => ['sometimes', 'required', 'date_format:Y-m-d'],
            'end_date' => ['sometimes', 'required', 'date_format:Y-m-d'],
            'format' => ['required', 'string', Rule::in(['json', 'xlsx'])],
        ];
    }

    public function messages()
    {
        return [
            "start_date.required" => "La fecha de inicio es requerida",
            "start_date.date_format" => "El formato de la fecha es Y-m-d",
            "end_date.required" => "La fecha final es requerida",
            "end_date.date_format" => "El formato de la fecha es Y-m-d",
            "format.required" => "El formato de salida es requerido",
            "format.in" => "El formato solo puede ser json o xlsx",
        ];
    }
}
