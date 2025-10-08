<?php

namespace App\Http\Requests\Admin\Mosul;

use Illuminate\Foundation\Http\FormRequest;

class RegsterauthRequest extends FormRequest
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
            'mosuls_name'     => 'required|string|max:255',
            'mosuls_email'    => 'required|email|unique:admins,admins_email',
            'mosuls_phone'    => 'required|numeric|unique:admins,admins_phone',
            'mosuls_password' => 'required|string|min:6',
        ];
    }
    public function messages(): array
    {
        return [
            'mosuls_name.required'     => 'الاسم مطلوب.',
            'mosuls_name.string'       => 'الاسم يجب أن يكون نصًا.',
            'mosuls_email.required'    => 'البريد الإلكتروني مطلوب.',
            'mosuls_email.email'       => 'صيغة البريد الإلكتروني غير صحيحة.',
            'mosuls_email.unique'      => 'البريد الإلكتروني مستخدم من قبل.',
            'mosuls_phone.required'    => 'رقم الهاتف مطلوب.',
            'mosuls_phone.numeric'     => 'رقم الهاتف يجب أن يحتوي على أرقام فقط.',
            'mosuls_phone.unique'      => 'رقم الهاتف مستخدم من قبل.',
            'mosuls_password.required' => 'كلمة المرور مطلوبة.',
            'mosuls_password.min'      => 'كلمة المرور يجب أن تكون على الأقل :min حروف.',
        ];
    }
}
