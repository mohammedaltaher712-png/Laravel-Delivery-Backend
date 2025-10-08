<?php

namespace App\Http\Requests\Users\Card;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
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

            'carts_menu_details' => 'required|integer|exists:menu_details,menu_details_id',
            'carts_quantitys' => 'required|integer|exists:quantitys,quantitys_id',
            'carts_orders' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [

            'carts_menu_details.required' => 'حقل تفاصيل القائمة مطلوب.',
            'carts_menu_details.integer' => 'يجب أن يكون رقم تفاصيل القائمة رقمًا صحيحًا.',
            'carts_menu_details.exists' => 'تفاصيل القائمة المحددة غير موجودة.',

            'carts_quantitys.required' => 'حقل الكمية مطلوب.',
            'carts_quantitys.integer' => 'يجب أن تكون الكمية رقمًا صحيحًا.',
            'carts_quantitys.exists' => 'الكمية المحددة غير موجودة.',

            'carts_orders.required' => 'حالة الخدمة مطلوبة.',
            'carts_orders.in' => 'قيمة حالة الخدمة غير صحيحة، يجب أن تكون "1" أو "0".',
        ];
    }
}
