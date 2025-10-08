<?php

namespace App\Http\Requests\Mosul;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'mosuls_email' => 'required|email',       // البريد الإلكتروني مطلوب ويجب أن يكون بريد صالح
            'mosuls_password' => 'required|string|min:6',  // كلمة المرور مطلوبة على الأقل 6 أحرف
        ];
    }

    // ممكن تضيف رسائل مخصصة لو حبيت
    public function messages()
    {
        return [
            'mosuls_email.required' => 'البريد الإلكتروني مطلوب',
            'mosuls_email.email' => 'يجب إدخال بريد إلكتروني صالح',
            'mosuls_password.required' => 'كلمة المرور مطلوبة',
            'mosuls_password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
        ];
    }
}
