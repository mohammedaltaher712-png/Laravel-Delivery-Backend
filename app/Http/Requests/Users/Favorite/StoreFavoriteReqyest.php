<?php

namespace App\Http\Requests\Users\Favorite;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavoriteReqyest extends FormRequest
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
            'favorites_services' => 'required|integer|exists:services,services_id',

        ];
    }
    public function messages(): array
    {
        return [

            'favorites_services.required' => 'حقل تفاصيل القائمة مطلوب.',
            'favorites_services.integer' => 'يجب أن يكون رقم تفاصيل القائمة رقمًا صحيحًا.',
            'favorites_services.exists' => 'تفاصيل القائمة المحددة غير موجودة.',

        ];
    }
}
