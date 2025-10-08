<?php

namespace App\Http\Requests\Admin\Services;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
        'services_name'        => 'required|string|max:255',
        'services_description' => 'required|string',
        'services_icon'        => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        'services_image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        'services_status'      => 'nullable|in:0,1',
        'services_category'    => 'required|exists:category,category_id',
        'services_belongs' => 'required|exists:service_provider,service_provider_id',

        'items'                => 'required|array|min:1',
        'items.*'              => 'exists:items,items_id',
    ];
}
public function messages(): array
{
    return [
        'services_name.required'        => 'اسم الخدمة مطلوب.',
        'services_name.string'          => 'اسم الخدمة يجب أن يكون نصاً.',
        'services_name.max'             => 'اسم الخدمة يجب ألا يتجاوز 255 حرفاً.',

        'services_description.required' => 'وصف الخدمة مطلوب.',
        'services_description.string'   => 'الوصف يجب أن يكون نصاً.',

        'services_icon.required'        => 'أيقونة الخدمة مطلوبة.',
        'services_icon.string'          => 'الأيقونة يجب أن تكون نصاً.',

        'services_image.required'       => 'صورة الخدمة مطلوبة.',
        'services_image.image'          => 'الملف يجب أن يكون صورة.',
        'services_image.mimes'          => 'امتداد الصورة يجب أن يكون jpeg أو png أو jpg أو webp.',
        'services_image.max'            => 'أقصى حجم للصورة هو 2 ميجابايت.',

        'services_status.in'            => 'حالة الخدمة يجب أن تكون إما 0 (غير مفعل) أو 1 (مفعل).',

        'services_category.required'    => 'يجب اختيار تصنيف الخدمة.',
        'services_category.exists'      => 'التصنيف المحدد غير موجود.',

        'items.required'                => 'يجب اختيار عنصر واحد على الأقل.',
        'items.array'                   => 'يجب إرسال العناصر في صيغة قائمة.',
        'items.min'                     => 'يجب اختيار عنصر واحد على الأقل.',
        'items.*.exists'                => 'أحد العناصر المحددة غير موجود في قاعدة البيانات.',
    ];
}
}
