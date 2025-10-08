<?php

namespace App\Http\Requests\Users\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdataAddressRequest extends FormRequest
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
        $id = $this->input('addressusers_id'); // ID الخاص بالعنوان

        return [
            'addressusers_id' => ['required', 'exists:addressusers,addressusers_id'],
            
            'addressusers_name' => [
                'sometimes',
                'string',
                'max:255',
                'unique:addressusers,addressusers_name,' . $id . ',addressusers_id',
            ],

            'addressusers_description' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'addressusers_latitude' => ['sometimes', 'numeric', ],
            'addressusers_longitude' => ['sometimes', 'numeric',],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'addressusers_id.required' => 'رقم العنوان مطلوب.',
            'addressusers_id.exists' => 'العنوان المحدد غير موجود.',

            'addressusers_name.string' => 'اسم العنوان يجب أن يكون نصًا.',
            'addressusers_name.max' => 'اسم العنوان لا يجب أن يتجاوز 255 حرفًا.',
            'addressusers_name.unique' => 'اسم العنوان مستخدم من قبل.',

            'addressusers_description.string' => 'الوصف يجب أن يكون نصًا.',
            'addressusers_description.max' => 'الوصف لا يجب أن يتجاوز 1000 حرف.',

            'addressusers_latitude.numeric' => 'خط العرض يجب أن يكون رقمًا.',
            'addressusers_latitude.between' => 'خط العرض يجب أن يكون بين -90 و 90.',

            'addressusers_longitude.numeric' => 'خط الطول يجب أن يكون رقمًا.',
            'addressusers_longitude.between' => 'خط الطول يجب أن يكون بين -180 و 180.',
        ];
    }
}
