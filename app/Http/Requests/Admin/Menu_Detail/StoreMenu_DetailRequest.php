<?php

namespace App\Http\Requests\Admin\Menu_Detail;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenu_DetailRequest extends FormRequest
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
            'menu_details_name'        => 'required|string|max:255',
            'menu_details_description' => 'nullable|string',
            'menu_details_price'       => 'required|numeric|min:0',
            'menu_details_image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'menu_details_menus'       => 'required|integer|exists:menus,menus_id',
                    'menu_details_services'       => 'required|integer|exists:services,services_id',

        ];
    }
    public function messages(): array
    {
        return [
            'menu_details_name.required'        => 'اسم الصنف مطلوب.',
            'menu_details_name.string'          => 'اسم الصنف يجب أن يكون نصاً.',
            'menu_details_name.max'             => 'اسم الصنف يجب ألا يتجاوز 255 حرفاً.',

            'menu_details_description.string'   => 'الوصف يجب أن يكون نصاً.',

            'menu_details_price.required'       => 'السعر مطلوب.',
            'menu_details_price.numeric'        => 'السعر يجب أن يكون رقماً.',
            'menu_details_price.min'            => 'السعر يجب ألا يكون سالباً.',

            'menu_details_image.image'          => 'يجب أن يكون الملف صورة.',
            'menu_details_image.mimes'          => 'نوع الصورة غير مدعوم، الصيغ المسموحة: jpeg, png, jpg, gif, webp.',
            'menu_details_image.max'            => 'حجم الصورة يجب ألا يتجاوز 2 ميغابايت.',

            'menu_details_menus.required'       => 'القائمة المرتبطة مطلوبة.',
            'menu_details_menus.integer'        => 'رقم القائمة غير صحيح.',
            'menu_details_menus.exists'         => 'القائمة المختارة غير موجودة.',

        ];
    }
}
