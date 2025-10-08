<?php

namespace App\Http\Requests\Admin\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'admins_name'     => 'required|string|max:255',
            'admins_email'    => 'required|email|unique:admins,admins_email',
            'admins_phone'    => 'required|numeric|unique:admins,admins_phone',
            'admins_password' => 'required|string|min:6',
        ];
    }
    public function messages(): array
{
    return [
        'admins_name.required'     => 'الاسم مطلوب.',
        'admins_name.string'       => 'الاسم يجب أن يكون نصًا.',
        'admins_email.required'    => 'البريد الإلكتروني مطلوب.',
        'admins_email.email'       => 'صيغة البريد الإلكتروني غير صحيحة.',
        'admins_email.unique'      => 'البريد الإلكتروني مستخدم من قبل.',
        'admins_phone.required'    => 'رقم الهاتف مطلوب.',
        'admins_phone.numeric'     => 'رقم الهاتف يجب أن يحتوي على أرقام فقط.',
        'admins_phone.unique'      => 'رقم الهاتف مستخدم من قبل.',
        'admins_password.required' => 'كلمة المرور مطلوبة.',
        'admins_password.min'      => 'كلمة المرور يجب أن تكون على الأقل :min حروف.',
    ];
}
}
