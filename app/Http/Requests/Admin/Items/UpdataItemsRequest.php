<?php

namespace App\Http\Requests\Admin\Items;

use Illuminate\Foundation\Http\FormRequest;

class UpdataItemsRequest extends FormRequest
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
    $id = $this->input('items_id'); // خذ ID من جسم الطلب نفسه

    return [
        'items_id' => ['required', 'exists:items,items_id'],
        'items_name' => [
            'sometimes',
            'string',
            'max:255',
            'unique:items,items_name,' . $id . ',items_id',
        ],
         'items_category' => ['sometimes', 'exists:category,category_id'],

        'items_image' => [
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
