<?php

namespace App\Http\Controllers;

use App\Models\TeamUser;
use App\Http\Requests\UserUpdateNicknameRequest;

class TeamUserController extends Controller
{
	protected $teamuser; 
	
	public function __construct(TeamUser $teamuser)
	{
	    $this->teamuser = $teamuser;
	}

    public function updateNickname(UserUpdateNicknameRequest $rq)
    {
        $this->teamuser->updateTeamUser(['nickname' => $rq->nickname], base64_decode($rq->id), base64_decode($rq->teamid));

        return response()->axios([
            'error' => false,
        ]);
    }
}
