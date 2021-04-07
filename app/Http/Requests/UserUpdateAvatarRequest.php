<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateAvatarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'u_avt' => 'bail|required|image|mimes:jpeg,bmp,png,webp|max:3072',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Vui lòng không bỏ trống',
            'image' => 'Chỉ chấp nhận file ảnh',
            'max' => 'Dung lượng tối đa 3MB',
            'mimes' => 'Chỉ cho phép định dạng jpg, jpeg, png, bmp, webp'
        ];
    }
}
