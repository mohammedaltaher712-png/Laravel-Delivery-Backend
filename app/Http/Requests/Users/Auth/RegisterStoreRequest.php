<?php

namespace App\Http\Requests\Users\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStoreRequest extends FormRequest
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
            'users_name'     => 'required|string|max:255',
            'users_email'    => 'required|email|unique:users,users_email',
            'users_phone'    => 'required|numeric|unique:users,users_phone',
            'users_password' => 'required|string|min:6',
        ];
    }
    public function messages(): array
{
    return [
        'users_name.required'     => 'الاسم مطلوب.',
        'users_name.string'       => 'الاسم يجب أن يكون نصًا.',
        'users_email.required'    => 'البريد الإلكتروني مطلوب.',
        'users_email.email'       => 'صيغة البريد الإلكتروني غير صحيحة.',
        'users_email.unique'      => 'البريد الإلكتروني مستخدم من قبل.',
        'users_phone.required'    => 'رقم الهاتف مطلوب.',
        'users_phone.numeric'     => 'رقم الهاتف يجب أن يحتوي على أرقام فقط.',
        'users_phone.unique'      => 'رقم الهاتف مستخدم من قبل.',
        'users_password.required' => 'كلمة المرور مطلوبة.',
        'users_password.min'      => 'كلمة المرور يجب أن تكون على الأقل :min حروف.',
        'users_password.confirmed'=> 'تأكيد كلمة المرور غير مطابق.',
    ];
}

}
