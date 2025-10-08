<?php

namespace App\Http\Requests\Admin\Service_provider;

use Illuminate\Foundation\Http\FormRequest;

class UpdataService_providerRequest extends FormRequest
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
        $id = $this->input('service_provider_id'); // تأكد أن هذا موجود في body

        return [
            'service_provider_id' => ['required', 'exists:service_provider,service_provider_id'],

            'service_provider_name' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'service_provider_email' => [
                'sometimes',
                'string',
                'email',
                'unique:service_provider,service_provider_email,' . $id . ',service_provider_id',
            ],

            'service_provider_phone' => [
                'sometimes',
                'numeric',
                'unique:service_provider,service_provider_phone,' . $id . ',service_provider_id',
            ],

            'service_provider_password' => [
                'sometimes',
                'string',
            ],
        ];
    }

}
