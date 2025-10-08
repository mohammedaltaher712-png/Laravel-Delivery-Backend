<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdataUsersRequest extends FormRequest
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
        $id = $this->input('users_id'); // تأكد أن هذا موجود في body

        return [
            'users_id' => ['required', 'exists:users,users_id'],

            'users_name' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'users_email' => [
                'sometimes',
                'string',
                'email',
                'unique:users,users_email,' . $id . ',users_id',
            ],

            'users_phone' => [
                'sometimes',
                'numeric',
                'unique:users,users_phone,' . $id . ',users_id',
            ],

            'users_password' => [
                'sometimes',
                'string',
            ],
        ];
    }
}
