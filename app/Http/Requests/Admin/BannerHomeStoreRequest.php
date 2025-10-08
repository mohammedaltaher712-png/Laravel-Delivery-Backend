<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerHomeStoreRequest extends FormRequest
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
         'banner_homes_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];
    }
    public function messages(): array
{
    return [
        'banner_homes_image.required' => 'صورة البانر مطلوبة.',
        'banner_homes_image.image' => 'الملف يجب أن يكون صورة.',
        'banner_homes_image.mimes' => 'الملف يجب أن يكون من نوع: jpeg, png, jpg, gif, svg.',
        'banner_homes_image.max' => 'الملف يجب ألا يتجاوز 2 ميغابايت.',
    ];
}

}
