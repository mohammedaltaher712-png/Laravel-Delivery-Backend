<?php

namespace App\Http\Requests\Admin\Service_provider;

use Illuminate\Foundation\Http\FormRequest;

class StoreService_providerRequest extends FormRequest
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
            'service_provider_name'     => 'required|string|max:255',
            'service_provider_email'    => 'required|email|unique:service_provider,service_provider_email',
            'service_provider_phone'    => 'required|numeric|unique:service_provider,service_provider_phone',
            'service_provider_password' => 'required|string|min:6',
        ];
    }
    public function messages(): array
    {
        return [
            'service_provider_name.required'     => 'الاسم مطلوب.',
            'service_provider_name.string'       => 'الاسم يجب أن يكون نصًا.',
            'service_provider_email.required'    => 'البريد الإلكتروني مطلوب.',
            'service_provider_email.email'       => 'صيغة البريد الإلكتروني غير صحيحة.',
            'service_provider_email.unique'      => 'البريد الإلكتروني مستخدم من قبل.',
            'service_provider_phone.required'    => 'رقم الهاتف مطلوب.',
            'service_provider_phone.numeric'     => 'رقم الهاتف يجب أن يحتوي على أرقام فقط.',
            'service_provider_phone.unique'      => 'رقم الهاتف مستخدم من قبل.',
            'service_provider_password.required' => 'كلمة المرور مطلوبة.',
            'service_provider_password.min'      => 'كلمة المرور يجب أن تكون على الأقل :min حروف.',
        ];
    }
}
