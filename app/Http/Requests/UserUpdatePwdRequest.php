<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckPassword;
use App\Rules\CheckRetypePassword;

class UserUpdatePwdRequest extends FormRequest
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
            'u_pwd' => ['bail', 'required', 'string', new CheckPassword],
            'u_npwd' => ['required', 'string', 'min:8'],
            'u_repwd' => ['bail', 'required', 'string', new CheckRetypePassword($this->u_npwd)],
        ];
    }
    
    public function messages()
    {
        return [
            'required' => 'Vui lòng không bỏ trống',
            'string' => 'Định dạng không hợp lệ',
            'min' => 'Tối thiểu 8 kí tự',
        ];
    }
}
