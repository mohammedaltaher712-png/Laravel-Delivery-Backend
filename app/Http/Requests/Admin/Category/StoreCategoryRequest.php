<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'category_name'  => 'required|string|max:255',
            'category_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // 2MB max
        ];
    }

    public function messages(): array
    {
        return [
            'category_name.required'  => 'اسم التصنيف مطلوب.',
            'category_name.string'    => 'اسم التصنيف يجب أن يكون نصاً.',
            'category_name.max'       => 'اسم التصنيف يجب ألا يتجاوز 255 حرفاً.',

            'category_image.required' => 'صورة التصنيف مطلوبة.',
            'category_image.image'    => 'الملف المرفوع يجب أن يكون صورة.',
            'category_image.mimes'    => 'امتداد الصورة يجب أن يكون jpeg أو png أو jpg أو gif أو svg أو webp.',
            'category_image.max'      => 'أقصى حجم للصورة هو 2 ميجابايت.',
        ];
    }
}
