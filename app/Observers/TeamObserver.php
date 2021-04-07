<?php

namespace App\Observers;

use App\Models\Team;
use App\Models\TeamUser;
use App\Models\TeamData;

class TeamObserver
{
    protected $teamuser, $teamdata;
    
	public function __construct(TeamUser $teamuser, TeamData $teamdata)
	{
	    $this->teamuser = $teamuser;

	    $this->teamdata = $teamdata;
	}
    /**
     * Handle the TeamUser "force deleted" event.
     *
     * @param  \App\Models\TeamUser  $teamUser
     * @return void
     */
    public function created(Team $team)
    {
    	$this->teamuser->createTeamUser(auth()->id(), $team->id);

    	$this->teamdata->createTeamData($team->id);
    }
}
