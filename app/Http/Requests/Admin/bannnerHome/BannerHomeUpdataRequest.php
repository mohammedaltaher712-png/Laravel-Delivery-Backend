<?php

namespace App\Http\Requests\Admin\bannnerHome;

use Illuminate\Foundation\Http\FormRequest;

class BannerHomeUpdataRequest extends FormRequest
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
    $id = $this->input('banner_homes_id'); // خذ ID من جسم الطلب نفسه

    return [
        'banner_homes_id' => ['required', 'exists:banner_homes,banner_homes_id'],
        
        'banner_homes_image' => [
            'sometimes',
            'image',
            'mimes:jpeg,png,jpg,gif,svg,webp',
            'max:2048',
        ],
    ];
}


public function messages(): array
{
    return [
      

        'banner_homes_image.image' => 'الملف يجب أن يكون صورة.',
        'banner_homes_image.mimes' => 'امتداد الصورة يجب أن يكون jpeg أو png أو jpg أو gif أو svg أو webp.',
        'banner_homes_image.max' => 'أقصى حجم للصورة هو 2 ميجابايت.',
    ];
}
}
