<?php

namespace App\Http\Requests\Admin\Menu_Detail;

use Illuminate\Foundation\Http\FormRequest;

class UpdataMenu_DetailRequest extends FormRequest
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
    // نأخذ الـ ID من الطلب نفسه، لو موجود
    $id = $this->input('menu_details_id');

    return [

        'menu_details_id' => ['required', 'exists:menu_details,menu_details_id'],
        'menu_details_name' => [
            'sometimes',
            'string',
            'max:255',
            // تحقق من التفرد مع استثناء السجل الحالي (للتحديث)
            'unique:menu_details,menu_details_name,' . $id . ',menu_details_id',
        ],

        'menu_details_description' => [
            'sometimes',
            'string',
        ],
         'menu_details_price' => [
            'sometimes',
            'numeric',
        ],


      

        'menu_details_image' => [
            'sometimes',
            'image',
            'mimes:jpeg,png,jpg,webp',
            'max:2048',
        ],

       

        'menu_details_menus' => [
            'sometimes',
            'exists:menus,menus_id',
        ],
        
        'menu_details_services' => [
            'sometimes',
            'exists:services,services_id',
        ],

       
    ];
}
public function messages(): array
{
    return [
        'menu_details_id.required'     => 'رقم الصنف مطلوب.',
        'menu_details_id.exists'       => 'الصنف غير موجود في قاعدة البيانات.',

        'menu_details_name.sometimes' => 'اسم الصنف مطلوب عند التعديل.',
        'menu_details_name.string'    => 'اسم الصنف يجب أن يكون نصًا.',
        'menu_details_name.max'       => 'اسم الصنف يجب ألا يتجاوز 255 حرفًا.',
        'menu_details_name.unique'    => 'اسم الصنف مستخدم مسبقًا.',

        'menu_details_description.string' => 'الوصف يجب أن يكون نصًا.',

        'menu_details_price.numeric'  => 'السعر يجب أن يكون رقمًا.',
        
        'menu_details_image.image'    => 'يجب أن يكون الملف صورة.',
        'menu_details_image.mimes'    => 'نوع الصورة غير مدعوم. الصيغ المسموحة: jpeg, png, jpg, webp.',
        'menu_details_image.max'      => 'حجم الصورة يجب ألا يتجاوز 2 ميغابايت.',

        'menu_details_menus.exists'   => 'القائمة المحددة غير موجودة.',
    ];
}

}
