<?php

namespace App\Http\Requests\Admin\Payment;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
        'payments_name' => 'required|string|max:255',
        'payments_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ];
}

   public function messages(): array
{
    return [
        'payments_name.required' => 'اسم الدفع مطلوب.',
        'payments_name.string' => 'اسم الدفع يجب أن يكون نصاً.',
        'payments_name.max' => 'اسم الدفع يجب ألا يتجاوز 255 حرفاً.',

        'payments_icon.image' => 'الملف يجب أن يكون صورة.',
        'payments_icon.mimes' => 'يجب أن تكون الصورة من نوع: jpeg, png, jpg, gif, svg.',
        'payments_icon.max' => 'أقصى حجم مسموح للصورة هو 2 ميجابايت.',
    ];
}


}
