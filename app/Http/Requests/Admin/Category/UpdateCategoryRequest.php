<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
    $id = $this->input('category_id'); // خذ ID من جسم الطلب نفسه

    return [
        'category_id' => ['required', 'exists:category,category_id'],
        'category_name' => [
            'sometimes',
            'string',
            'max:255',
            'unique:category,category_name,' . $id . ',category_id',
        ],
        'category_image' => [
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
        'category_name.string' => 'اسم التصنيف يجب أن يكون نصًا.',
        'category_name.max' => 'اسم التصنيف يجب ألا يتجاوز 255 حرفًا.',
        'category_name.unique' => 'اسم التصنيف مستخدم من قبل.',

        'category_image.image' => 'الملف يجب أن يكون صورة.',
        'category_image.mimes' => 'امتداد الصورة يجب أن يكون jpeg أو png أو jpg أو gif أو svg أو webp.',
        'category_image.max' => 'أقصى حجم للصورة هو 2 ميجابايت.',
    ];
}

}
