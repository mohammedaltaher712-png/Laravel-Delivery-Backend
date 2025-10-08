<?php

namespace App\Http\Requests\Admin\Items;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemsRequest extends FormRequest
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
        'items_name'      => 'required|string|max:255|unique:items,items_name',
            'items_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', 
            'items_category' => 'required|exists:category,category_id',
        ];
    }
     public function messages(): array
    {
        return [
            'items_name.required' => 'اسم التصنيف مطلوب.',
             'items_name.string'   => 'اسم التصنيف يجب أن يكون نصاً.',
             'items_name.max'      => 'اسم التصنيف يجب ألا يتجاوز 255 حرفاً.',
             'items_name.unique'   => 'هذا الاسم موجود بالفعل، يرجى اختيار اسم مختلف.',

            'items_image.required' => 'صورة التصنيف مطلوبة.',
            'items_image.image'    => 'الملف المرفوع يجب أن يكون صورة.',
            'items_image.mimes'    => 'امتداد الصورة يجب أن يكون jpeg أو png أو jpg أو gif أو svg أو webp.',
            'items_image.max'      => 'أقصى حجم للصورة هو 2 ميجابايت.',

            
            'items_category.required' => 'يجب اختيار التصنيف المرتبط بالبانر.',
            'items_category.exists' => 'التصنيف المحدد غير موجود.',
        ];
    }
}
