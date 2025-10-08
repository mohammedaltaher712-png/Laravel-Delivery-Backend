<?php

namespace App\Http\Requests\Admin\Service_providerAdress;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'addressservices_name' => 'required|string|max:255',
            'addressservices_description' => 'nullable|string|max:1000',
            'addressservices_latitude' => 'required|numeric',
            'addressservices_longitude' => 'required|numeric',
                        'addressservices_service' => 'required|exists:services,services_id',

        ];
    }
    public function messages(): array
    {
        return [
            'addressservices_name.required' => 'اسم العنوان مطلوب.',
            'addressservices_name.string' => 'اسم العنوان يجب أن يكون نصًا.',
            'addressservices_name.max' => 'اسم العنوان لا يجب أن يتجاوز 255 حرفًا.',

            'addressservices_description.string' => 'الوصف يجب أن يكون نصًا.',
            'addressservices_description.max' => 'الوصف لا يجب أن يتجاوز 1000 حرف.',

            'addressservices_latitude.required' => 'خط العرض مطلوب.',
            'addressservices_latitude.numeric' => 'خط العرض يجب أن يكون رقمًا.',
            'addressservices_latitude.between' => 'خط العرض يجب أن يكون بين -90 و 90.',

            'addressservices_longitude.required' => 'خط الطول مطلوب.',
            'addressservices_longitude.numeric' => 'خط الطول يجب أن يكون رقمًا.',
            'addressservices_longitude.between' => 'خط الطول يجب أن يكون بين -180 و 180.',

        ];
    }
}
