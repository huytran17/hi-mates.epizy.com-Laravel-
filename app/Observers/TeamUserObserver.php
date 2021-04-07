<?php

namespace App\Observers;

use App\Models\TeamUser;
use App\Models\Message;

class TeamUserObserver
{
    /**
     * Handle the TeamUser "force deleted" event.
     *
     * @param  \App\Models\TeamUser  $teamUser
     * @return void
     */
    public function forceDeleted(TeamUser $teamUser)
    {
        Message::where([
            'user_id' => $teamUser->user_id,
            'team_id' => $teamUser->team_id
        ])->forceDelete();
    }
}
