<?php

namespace App\Http\Requests\Admin\Menu;

use Illuminate\Foundation\Http\FormRequest;

class UpdataMenusRequest extends FormRequest
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
        $id = $this->input('menus_id'); // خذ ID من جسم الطلب نفسه

        return [
  'menus_id' => ['required', 'exists:menus,menus_id'],
        'menus_name' => [
            'sometimes',
            'string',
            'max:255',
            'unique:menus,menus_name,' . $id . ',menus_id',
        ],
                     'menus_services' => ['sometimes', 'exists:services,services_id'],

        ];
    }
}
