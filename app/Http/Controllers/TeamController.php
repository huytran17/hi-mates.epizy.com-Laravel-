<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\TeamData;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Requests\TeamStoreMemberRequest;
use App\Http\Requests\TeamJoinMemberRequest;
use App\Http\Requests\TeamChangeNameRequest;

class TeamController extends Controller
{
    protected $team, $user, $teamuser; 

    public function __construct(Team $team, User $user, TeamUser $teamuser)
    {
        $this->team = $team;

        $this->user = $user;

        $this->teamuser = $teamuser;
    }

    public function show(Request $rq)
    {
    	$id = base64_decode($rq->id);

        if ($this->teamuser->isExists(auth()->id(), $id)) $team = $this->team->getByIdWithCountUser($id);
        else $this->getViewResponse('toast_notice', 'client.toast', false, ['content' => 'Nhóm không tồn tại']);

        return response()->axios([
            'error' => false,
            'view_msg_frame' => View::make('client.message-frame', ['team' => json_encode($team)])->render(),
            'view_team_mems' => View::make('client.team-members', ['team' => json_encode($team)])->render(),
            'teamid' => $rq->id,
            'remainingMsg' => $team->allMessages->count() - 20,
            'allmsg' => $team->allMessages->count()
        ]);
    }

    public function create()
    {
        return $this->getViewResponse('modal', 'client.modal-create-team', false);
    }

    public function join()
    {
        return $this->getViewResponse('modal', 'client.modal-join-team', false);
    }

    public function add(Request $rq)
    {
        return $this->getViewResponse('modal', 'client.add-member', false, ['teamID' => $rq->teamID]);
    }

    public function store(TeamStoreRequest $rq)
    {
        $joincode = $this->getJoinCode();

        return $this->team->createTeam([
            'name' => $rq->name,
            'slug' => $rq->name,
            'join_code' => $joincode,
            'created_by' => auth()->id(),
        ]);
    }

    public function storeMember(TeamStoreMemberRequest $rq)
    {
    	$user = $this->user->getByName($rq->name);

    	$team = $this->team->findOrFail(base64_decode($rq->teamID));

        $this->teamuser->createTeamUser($user->id, $team->id);

        return $this->getViewResponse('view_team_mems', 'client.team-members', false, [
                'team' => json_encode($this->team->getById($team->id))
            ]);
    }

    public function storeJoinMember(TeamJoinMemberRequest $rq)
    {
        $team = $this->team->getByJoinCode($rq->join_code);

       	$this->teamuser->createTeamUser(auth()->id(), $team->id);

       	return response()->axios([
            'error' => false,
        ]);
    }

    public function renewJoinCode(Request $rq)
    {
        $newCode = $this->getJoinCode();

        $this->team->updateTeam(['join_code' => $newCode], $rq->teamID);

        return response()->axios([
            'newcode' => $newCode,
        ]);
    }

    public function getJoinCode()
    {
        do {
            $newCode = Str::random(7);
        } while ($this->team->hasJoinCode($newCode));

        return $newCode;
    }

    public function getChgBgModal(Request $rq)
    {
        $team = $this->team->getByIdWithException(base64_decode($rq->teamID));

        return $this->getViewResponse('modal', 'client.modal-change-team-bg', false, ['teamID' => $team->encrypted_id]);
    }

    public function getChgColorModal(Request $rq)
    {
        $team = $this->team->getByIdWithRelateOnly(['team_data'], base64_decode($rq->teamID));

        return $this->getViewResponse('modal', 'client.modal-change-team-color', false, [
                'teamID' => $team->encrypted_id,
                'color' => $team->team_data->color
            ]);
    }

    public function getLeaveTeamModal(Request $rq)
    {
        $team = $this->team->getByIdWithException(base64_decode($rq->teamID));
        
        return $this->getViewResponse('modal', 'client.modal-leave-team', false, ['teamID' => $team->encrypted_id]);
    }

    public function getDestroyTeamModal(Request $rq)
    {
        $team = $this->team->getByIdWithException(base64_decode($rq->teamID));
        
        return $this->getViewResponse('modal', 'client.modal-destroy-team', false, ['teamID' => $team->encrypted_id]);
    }

    public function getDestroyMemModal(Request $rq)
    {
        $user = $this->user->getById(base64_decode($rq->memID));

        return $this->getViewResponse('modal', 'client.modal-destroy-member', false, [
            'memID' => $rq->memID, 
            'teamID' => $rq->teamID
        ]);
    }

    public function leave(Request $rq)
    {
        $this->teamuser->destroyMember(auth()->id(), base64_decode($rq->id));

        return response()->axios([
            'error' => false
        ]);
    }

    public function destroy(Request $rq)
    {
        return $this->team->destroyTeam(base64_decode($rq->id));
    }

    public function destroyMember(Request $rq)
    {
        $this->teamuser->destroyMember(base64_decode($rq->memid), base64_decode($rq->teamid));

        return $this->getViewResponse('view_team_mems', 'client.team-members', false, [
                'team' => json_encode($this->team->getByIdWithRelateOnly(['users'], base64_decode($rq->teamid)))
            ]);
    }

    public function refreshList(Request $rq)
    {
        $teams = $this->user->getByIdWithException(auth()->id())->teams;

        return $this->getViewResponse('list_team', 'client.list-team', false, ['teams' => json_encode($teams)]);
    }

    public function refreshTeamMem(Request $rq)
    {
        $team = $this->team->getByIdWithRelateOnly(['users'], base64_decode($rq->teamid));

        return $this->getViewResponse('view_team_mems', 'client.team-members', false, ['team' => json_encode($team)]);
    }

    public function getChgNameModal(Request $rq)
    {
        $team = $this->team->getByIdWithException(base64_decode($rq->teamID));

        return $this->getViewResponse('modal', 'client.modal-change-team-name', false, ['teamID' => $team->encrypted_id]);
    }

    public function changeTeamName(TeamChangeNameRequest $rq)
    {
        $this->team->updateTeam(['name' => trim($rq->team_name)], base64_decode($rq->teamid));

        return response()->axios([
            'error' => false,
        ]);
    }
}