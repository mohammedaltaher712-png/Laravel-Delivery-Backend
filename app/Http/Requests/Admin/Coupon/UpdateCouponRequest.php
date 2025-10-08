<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * تجهيز البيانات قبل التحقق (تحويل is_active إلى Boolean)
     */

    public function rules(): array
    {
        return [
            'coupons_id' => ['required', 'exists:coupons,coupons_id'],

            'coupons_name' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'coupons_discount' => [
                'sometimes',
                'integer',
                'min:1',
                'max:100',
            ],

            'coupons_user' => [
                'sometimes',
                'numeric',
                'exists:users,users_id',
            ],

            'coupons_start_date' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'coupons_end_date' => [
                'sometimes',
                'nullable',
                'string',
                'after:coupons_start_date',
            ],

            'coupons_is_active' => [
                'sometimes',
                'integer', // ✅ يتحقق من true/false أو 1/0
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'coupons_id.required' => 'رقم الكوبون مطلوب.',
            'coupons_id.exists' => 'الكوبون غير موجود.',

            'coupons_name.string' => 'اسم الكوبون يجب أن يكون نصًا.',
            'coupons_name.max' => 'اسم الكوبون لا يجب أن يتجاوز 255 حرفًا.',

            'coupons_discount.integer' => 'قيمة الخصم يجب أن تكون رقمًا صحيحًا.',
            'coupons_discount.min' => 'الحد الأدنى لقيمة الخصم هو 1٪.',
            'coupons_discount.max' => 'الحد الأقصى لقيمة الخصم هو 100٪.',

            'coupons_user.exists' => 'المستخدم المحدد غير موجود.',
            'coupons_belongs_service.exists' => 'مزود الخدمة المحدد غير موجود.',

            'coupons_start_date.date' => 'تاريخ بدء الكوبون غير صالح.',
            'coupons_end_date.date' => 'تاريخ انتهاء الكوبون غير صالح.',
            'coupons_end_date.after' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البدء.',

            'coupons_is_active.boolean' => 'حالة التفعيل يجب أن تكون 0 أو 1 أو true أو false.',
        ];
    }
}
