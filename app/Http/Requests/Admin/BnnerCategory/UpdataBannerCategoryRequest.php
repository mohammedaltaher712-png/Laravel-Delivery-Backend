<?php

namespace App\Http\Requests\Admin\BnnerCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdataBannerCategoryRequest extends FormRequest
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
    $id = $this->input('banner_categorys_id'); // خذ ID من جسم الطلب نفسه

    return [
        'banner_categorys_id' => ['required', 'exists:banner_categorys,banner_categorys_id'],
        'banner_categorys_category' => ['sometimes', 'exists:category,category_id'],
        'banner_categorys_image' => [
            'sometimes',
            'image',
            'mimes:jpeg,png,jpg,gif,svg,webp',
            'max:2048',
        ],
    ];
}
public function messages(): array
{
    return [
        'banner_categorys_id.required' => 'معرف الفئة الإعلانية مطلوب.',
        'banner_categorys_id.exists' => 'معرف الفئة الإعلانية غير موجود في النظام.',

        'banner_categorys_category.exists' => 'الفئة المرتبطة غير موجودة في جدول التصنيفات.',

        'banner_categorys_image.image' => 'يجب أن يكون الملف صورة.',
        'banner_categorys_image.mimes' => 'امتداد الصورة يجب أن يكون jpeg أو png أو jpg أو gif أو svg أو webp.',
        'banner_categorys_image.max' => 'أقصى حجم للصورة هو 2 ميجابايت.',
    ];
}

}
