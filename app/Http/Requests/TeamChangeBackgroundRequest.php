<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\View;

class TeamChangeBackgroundRequest extends FormRequest
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
            'tm_bg' => 'bail|required|image|mimes:jpeg,bmp,png,webp|max:765'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Vui lòng không bỏ trống',
            'image' => 'Vui lòng chỉ chọn file ảnh',
            'mimes' => 'Chỉ cho phép định dạng jpg, png, webp',
            'max' => 'Kích thước tối đa 765KB'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->axios([
                'error' => true,
                'toast_notice' => View::make('client.toast', ['content' => $validator->errors()->first()])->render(),
            ])
        );
    }
}
