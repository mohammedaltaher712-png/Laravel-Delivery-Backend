<?php

namespace App\Http\Requests\Admin\Quantity;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuantityRequest extends FormRequest
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
        'quantitys_name'        => 'required|string|max:255',
        'quantitys_price'       => 'required|numeric|min:0',
        'quantitys_menu_details'       => 'required|integer|exists:menu_details,menu_details_id',
    ];
}
public function messages(): array
    {
        return [
            'quantitys_name.required'         => 'اسم الكمية مطلوب.',
            'quantitys_name.string'           => 'اسم الكمية يجب أن يكون نصًا.',
            'quantitys_name.max'              => 'اسم الكمية لا يجب أن يتجاوز 255 حرفًا.',

            'quantitys_price.required'        => 'سعر الكمية مطلوب.',
            'quantitys_price.numeric'         => 'السعر يجب أن يكون رقمًا.',
            'quantitys_price.min'             => 'السعر يجب ألا يكون أقل من 0.',

            'quantitys_menu_details.required' => 'رقم الصنف المرتبط مطلوب.',
            'quantitys_menu_details.integer'  => 'رقم الصنف غير صالح.',
            'quantitys_menu_details.exists'   => 'الصنف المرتبط غير موجود.',
        ];
    }
}
