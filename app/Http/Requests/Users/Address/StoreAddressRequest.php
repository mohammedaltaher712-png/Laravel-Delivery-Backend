<?php

namespace App\Http\Requests\Users\Address;

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
            'addressusers_name' => 'required|string|max:255',
            'addressusers_description' => 'nullable|string|max:1000',
            'addressusers_latitude' => 'required|numeric',
            'addressusers_longitude' => 'required|numeric',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'addressusers_name.required' => 'اسم العنوان مطلوب.',
            'addressusers_name.string' => 'اسم العنوان يجب أن يكون نصًا.',
            'addressusers_name.max' => 'اسم العنوان لا يجب أن يتجاوز 255 حرفًا.',

            'addressusers_description.string' => 'وصف العنوان يجب أن يكون نصًا.',
            'addressusers_description.max' => 'وصف العنوان لا يجب أن يتجاوز 1000 حرف.',

            'addressusers_latitude.required' => 'خط العرض مطلوب.',
            'addressusers_latitude.numeric' => 'خط العرض يجب أن يكون رقمًا.',
            'addressusers_latitude.between' => 'خط العرض يجب أن يكون بين -90 و 90.',

            'addressusers_longitude.required' => 'خط الطول مطلوب.',
            'addressusers_longitude.numeric' => 'خط الطول يجب أن يكون رقمًا.',
            'addressusers_longitude.between' => 'خط الطول يجب أن يكون بين -180 و 180.',

        ];
    }
}
