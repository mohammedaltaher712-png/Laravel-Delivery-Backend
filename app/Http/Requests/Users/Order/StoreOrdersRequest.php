<?php

namespace App\Http\Requests\Users\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrdersRequest extends FormRequest
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
            'orders_address'      => 'required|exists:addressusers,addressusers_id',
                        'orders_address_serivce'      => 'required|exists:addressservices,addressservices_id',

            'orders_coupon'       => 'nullable|integer|min:0',
           'orders_services'      => 'required|exists:services,services_id',
            'orders_status' => 'required|integer',

            'orders_pricedelivery' => 'required|integer|min:0',
            'orders_price'        => 'required|integer|min:0',
            'orders_paymentmethod' => 'required|exists:payments,payments_id',
            'discountcoupon'       => 'nullable|numeric|min:0|max:100',
             'orders_comments' => 'nullable|string',

        ];
    }
    public function messages(): array
    {
        return [

            'menus_services.required'       => 'حقل الخدمة مطلوب.',
            'menus_services.exists'         => 'الخدمة المحددة غير موجودة.',

            'orders_address.required'       => 'العنوان مطلوب.',
            'orders_address.string'         => 'يجب أن يكون العنوان نصًا.',
            'orders_address.max'            => 'العنوان طويل جدًا، الحد الأقصى 255 حرفًا.',

            'orders_coupon.integer'         => 'قيمة الكوبون يجب أن تكون رقمًا.',
            'orders_coupon.min'             => 'قيمة الكوبون لا يمكن أن تكون سالبة.',

            'orders_pricedelivery.required' => 'سعر التوصيل مطلوب.',
            'orders_pricedelivery.integer'  => 'سعر التوصيل يجب أن يكون رقمًا.',
            'orders_pricedelivery.min'      => 'سعر التوصيل لا يمكن أن يكون أقل من صفر.',

            'orders_price.required'         => 'السعر مطلوب.',
            'orders_price.integer'          => 'السعر يجب أن يكون رقمًا.',
            'orders_price.min'              => 'السعر لا يمكن أن يكون أقل من صفر.',

            'orders_paymentmethod.required' => 'طريقة الدفع مطلوبة.',
            'orders_paymentmethod.in'       => 'طريقة الدفع غير صالحة (اختر "cash" أو "online").',
        ];
    }

}
