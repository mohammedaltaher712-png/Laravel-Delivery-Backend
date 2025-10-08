<?php

namespace App\Http\Requests\Admin\Service_providerAdress;

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
        $id = $this->input('addressservices_id'); // خذ ID من جسم الطلب نفسه

        return [
            'addressservices_id' => ['required', 'exists:addressservices,addressservices_id'],
            'addressservices_name' => [
                'sometimes',
                'string',
                'max:255',
                'unique:addressservices,addressservices_name,' . $id . ',addressservices_id',
            ],
             'addressservices_service' => ['sometimes', 'exists:services,services_id'],
  'addressservices_description' => [
                    'sometimes',
                    'string',
                    'max:255',
                ],
                 'addressservices_latitude' => [
                    'sometimes',
                    'numeric',
                
                ],
                 'addressservices_longitude' => [
                    'sometimes',
                    'numeric',
               
                ],
        ];

    }
}
