<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\View;
use App\Rules\TeamUserExist;
use App\Models\TeamUser;
use App\Models\Team;

class TeamJoinMemberRequest extends FormRequest
{
    protected $team, $teamuser;
    
    public function __construct(Team $team, TeamUser $teamuser)
    {
        $this->team = $team;

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
        $this->team = $this->team->getByJoinCode($this->join_code);
        $teamid = $this->getTeamId($this->team);

        return [
            'join_code' => ['bail', 'required', 'exists:teams', new TeamUserExist($this->teamuser, auth()->id(), $teamid)],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Vui lòng không bỏ trống',
            'exists' => 'Nhóm không tồn tại',
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

    public function getTeamId($team)
    {
        if (!empty($team)) return $team->id;
        return null;
    }
}
