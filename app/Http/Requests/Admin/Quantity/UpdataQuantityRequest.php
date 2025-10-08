<?php

namespace App\Http\Requests\Admin\Quantity;

use Illuminate\Foundation\Http\FormRequest;

class UpdataQuantityRequest extends FormRequest
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
        // نأخذ الـ ID من الطلب نفسه، لو موجود
        $id = $this->input('quantitys_id');

        return [

            'quantitys_id' => ['required', 'exists:quantitys,quantitys_id'],
            'quantitys_name' => [
                'sometimes',
                'string',
                'max:255',
                // تحقق من التفرد مع استثناء السجل الحالي (للتحديث)
                'unique:quantitys,quantitys_name,' . $id . ',quantitys_id',
            ],

             'quantitys_price' => [
                'sometimes',
                'numeric',
            ],

            'quantitys_menu_details' => [
                'sometimes',
                'exists:menu_details,menu_details_id',
            ],

        ];
    }
}
