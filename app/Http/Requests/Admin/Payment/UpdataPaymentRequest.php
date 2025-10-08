<?php

namespace App\Http\Requests\Admin\Payment;

use Illuminate\Foundation\Http\FormRequest;

class UpdataPaymentRequest extends FormRequest
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
            'payments_id' => ['required', 'exists:payments,payments_id'],

            'payments_name' => [
                'sometimes',
                'string',
                'max:255',
            ],

           'payments_icon' => [
            'sometimes',
            'image',
            'mimes:jpeg,png,jpg,gif,svg,webp',
            'max:2048',
        ],
        ];
    }

}
