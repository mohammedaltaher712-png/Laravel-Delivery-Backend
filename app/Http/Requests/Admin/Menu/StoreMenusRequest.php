<?php

namespace App\Http\Requests\Admin\Menu;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenusRequest extends FormRequest
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
        'menus_name' => 'required|string|max:255',
        'menus_services' => 'required|integer|exists:services,services_id',
    ];
}

public function messages(): array
{
    return [
        'menus_name.required' => 'اسم القائمة مطلوب.',
        'menus_name.string' => 'اسم القائمة يجب أن يكون نصًا.',
        'menus_name.max' => 'اسم القائمة يجب ألا يتجاوز 255 حرفًا.',

        'menus_services.required' => 'الخدمة المرتبطة مطلوبة.',
        'menus_services.integer' => 'الخدمة المرتبطة يجب أن تكون رقمًا.',
        'menus_services.exists' => 'الخدمة المرتبطة غير موجودة في قاعدة البيانات.',
    ];
}
}
