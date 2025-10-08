<?php

namespace App\Http\Requests\Admin\BnnerCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerCategoryRequest extends FormRequest
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
            'banner_categorys_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'banner_categorys_category' => 'required|exists:category,category_id',
        ];
    }

    public function messages(): array
    {
        return [
            'banner_categorys_image.required' => 'يجب رفع صورة البانر.',
            'banner_categorys_image.image' => 'الملف يجب أن يكون صورة.',
            'banner_categorys_image.mimes' => 'امتداد الصورة يجب أن يكون jpeg أو png أو jpg أو gif أو svg أو webp.',
            'banner_categorys_image.max' => 'أقصى حجم للصورة هو 2 ميجابايت.',

            'banner_categorys_category.required' => 'يجب اختيار التصنيف المرتبط بالبانر.',
            'banner_categorys_category.exists' => 'التصنيف المحدد غير موجود.',
        ];
    }
}
