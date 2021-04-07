<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeamData;
use App\Models\Team;
use App\Services\UploadFileService;
use App\Http\Requests\TeamChangeBackgroundRequest;

class TeamDataController extends Controller
{
	protected $teamdata, $team, $uploadFileService;
	
	public function __construct(TeamData $teamdata, Team $team, UploadFileService $uploadFileService)
	{
		$this->teamdata = $teamdata;    

		$this->team = $team;

		$this->uploadFileService = $uploadFileService;
	}

    public function changeColor(Request $rq)
    {
        $id = base64_decode($rq->teamID);

        $this->teamdata->updateByTeamId($rq->only('color'), $id);

        $team = $this->team->getByIdWithCountUser($id);

        return $this->getViewResponse('view_msg_frame', 'client.message-frame', false, ['team' => json_encode($team)]);
    }

    public function changeBackground(TeamChangeBackgroundRequest $rq)
    {
        $img = $this->uploadFileService->getBase64Image($rq->file('tm_bg'));

        $this->teamdata->updateByTeamId(['background' => $img], base64_decode($rq->teamID));

        return response()->axios([
            'error' => false,
            'bgimg' => $img,
        ]);
    }

    public function destroyBackground(Request $rq)
    {
        $this->teamdata->updateByTeamId(['background' => null], base64_decode($rq->teamID));

        return response()->axios([
            'error' => false,
        ]);
    }
}
