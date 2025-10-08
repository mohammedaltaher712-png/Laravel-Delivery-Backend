<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'coupons_name' => 'required|string|max:255',
            'coupons_discount' => 'required|integer|min:1|max:100',
            'coupons_user' => 'required|exists:users,users_id',
             'coupons_start_date' => 'nullable|string',
            'coupons_end_date' => 'nullable|string|after:coupons_start_date',

            'coupons_is_active' => 'integer',
        ];
    }
    public function messages(): array
    {
        return [
            'coupons_name.required' => 'اسم الكوبون مطلوب.',
            'coupons_name.string' => 'اسم الكوبون يجب أن يكون نصًا.',
            'coupons_name.max' => 'اسم الكوبون لا يجب أن يتجاوز 255 حرفًا.',

            'coupons_discount.required' => 'قيمة الخصم مطلوبة.',
            'coupons_discount.integer' => 'قيمة الخصم يجب أن تكون رقمًا صحيحًا.',
            'coupons_discount.min' => 'الحد الأدنى لقيمة الخصم هو 1٪.',
            'coupons_discount.max' => 'الحد الأقصى لقيمة الخصم هو 100٪.',

            'coupons_user.required' => 'المستخدم المرتبط بالكوبون مطلوب.',
            'coupons_user.exists' => 'المستخدم المحدد غير موجود.',

            'coupons_start_date.date' => 'تاريخ بدء الكوبون غير صالح.',
            'coupons_end_date.date' => 'تاريخ انتهاء الكوبون غير صالح.',
            'coupons_end_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء.',

            'coupons_is_active.boolean' => 'حالة التفعيل يجب أن تكون صح أو خطأ فقط.',
        ];
    }
}
