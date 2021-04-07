<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckRetypePassword;

class UserRegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'email', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => 
            ['required', 'string', new CheckRetypePassword($this->password)],
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Vui lòng không bỏ trống',
            'string' => 'Định dạng không phù hợp',
            'max' => 'Tối đa 255 ký tự',
            'name.unique' => 'Tên người dùng đã tồn tại',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'min' => 'Tối thiểu 8 ký tự',
        ];
    }
}
