<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\View;
use App\Rules\TeamUserExist;
use App\Models\User;
use App\Models\TeamUser;

class TeamStoreMemberRequest extends FormRequest
{
    protected $user, $teamuser;
    
    public function __construct(User $user, TeamUser $teamuser)
    {
        $this->user = $user;

        $this->teamuser = $teamuser;
    }
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
        $this->user = $this->user->getByName($this->name);
        $userid = $this->getUserId($this->user);

        return [
           'name' => ['bail', 'required', 'max:255', 'exists:users', new TeamUserExist($this->teamuser, $userid, base64_decode($this->teamID))],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Vui lòng không bỏ trống',
            'max' => 'Tối đa 255 kí tự',
            'exists' => 'Người dùng không tồn tại',
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

    public function getUserId($user)
    {
        if (!empty($user)) return $user->id;
        return null;
    }
}
