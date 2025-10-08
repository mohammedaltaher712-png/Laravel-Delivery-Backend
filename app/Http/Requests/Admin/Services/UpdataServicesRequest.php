<?php

namespace App\Http\Requests\Admin\Services;

use Illuminate\Foundation\Http\FormRequest;

class UpdataServicesRequest extends FormRequest
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
    $id = $this->input('services_id');

    return [
        'services_id' => ['required', 'exists:services,services_id'],

        // الحقول التالية اختيارية أثناء التحديث (قد لا ترسلها)
        'services_name' => [
            'sometimes',
            'string',
            'max:255',
            // تحقق من التفرد مع استثناء السجل الحالي (للتحديث)
            'unique:services,services_name,' . $id . ',services_id',
        ],

        'services_description' => [
            'sometimes',
            'string',
        ],

        'services_icon' => [
            'sometimes',
            'image',
            'mimes:jpeg,png,jpg,webp',
            'max:2048',
        ],

        'services_image' => [
            'sometimes',
            'image',
            'mimes:jpeg,png,jpg,webp',
            'max:2048',
        ],

        'services_status' => [
            'sometimes',
            'in:0,1',
        ],

        'services_category' => [
            'sometimes',
            'exists:category,category_id',
        ],

        'services_belongs' => [
            'sometimes',
            'exists:service_provider,service_provider_id',
        ],

        'items' => [
            'sometimes',
            'array',
            'min:1',
        ],

        'items.*' => [
            'exists:items,items_id',
        ],
    ];
}
public function messages(): array
{
    return [
        'services_id.required' => 'معرّف الخدمة مطلوب.',
        'services_id.exists'   => 'الخدمة المحددة غير موجودة.',

        'services_name.string'  => 'اسم الخدمة يجب أن يكون نصاً.',
        'services_name.max'     => 'اسم الخدمة يجب ألا يتجاوز 255 حرفاً.',
        'services_name.unique'  => 'اسم الخدمة موجود مسبقاً.',

        'services_description.string' => 'وصف الخدمة يجب أن يكون نصاً.',

        'services_icon.image'   => 'أيقونة الخدمة يجب أن تكون صورة.',
        'services_icon.mimes'   => 'امتداد أيقونة الخدمة يجب أن يكون jpeg أو png أو jpg أو webp.',
        'services_icon.max'     => 'حجم أيقونة الخدمة يجب ألا يتجاوز 2 ميجابايت.',

        'services_image.image'  => 'صورة الخدمة يجب أن تكون صورة.',
        'services_image.mimes'  => 'امتداد صورة الخدمة يجب أن يكون jpeg أو png أو jpg أو webp.',
        'services_image.max'    => 'حجم صورة الخدمة يجب ألا يتجاوز 2 ميجابايت.',

        'services_status.in'    => 'حالة الخدمة يجب أن تكون 0 (غير مفعل) أو 1 (مفعل).',

        'services_category.exists' => 'التصنيف المحدد للخدمة غير موجود.',

        'services_belongs.exists' => 'مزود الخدمة المحدد غير موجود.',

        'items.array'           => 'يجب إرسال العناصر في صيغة قائمة.',
        'items.min'             => 'يجب اختيار عنصر واحد على الأقل.',
        'items.*.exists'        => 'أحد العناصر المحددة غير موجود في قاعدة البيانات.',
    ];
}

}
