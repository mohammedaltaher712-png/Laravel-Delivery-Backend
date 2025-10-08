<?php

namespace App\Http\Requests\Admin\Mosul;

use Illuminate\Foundation\Http\FormRequest;

class UpdataMosulRequest extends FormRequest
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
        $id = $this->input('mosuls_id'); // تأكد أن هذا موجود في body

        return [
            'mosuls_id' => ['required', 'exists:mosuls,mosuls_id'],

            'mosuls_name' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'mosuls_email' => [
                'sometimes',
                'string',
                'email',
                'unique:mosuls,mosuls_email,' . $id . ',mosuls_id',
            ],

            'mosuls_phone' => [
                'sometimes',
                'numeric',
                'unique:mosuls,mosuls_phone,' . $id . ',mosuls_id',
            ],

            'mosuls_password' => [
                'sometimes',
                'string',
            ],
        ];
    }
}
