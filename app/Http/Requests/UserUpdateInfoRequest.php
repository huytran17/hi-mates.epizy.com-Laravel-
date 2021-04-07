<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CheckPassword;
class UserUpdateInfoRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'u_c_pwd' => ['bail', 'required', 'string', new CheckPassword]
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Vui lòng không bỏ trống',
            'string' => 'Định dạng không hợp lệ',
            'max' => 'Tối đa 255 kí tự',
            'unique' => 'Tên đăng nhập đã tồn tại',
        ];
    }
}
