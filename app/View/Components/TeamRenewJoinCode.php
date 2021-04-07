<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TeamRenewJoinCode extends Component
{
    public $teamID;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($teamID)
    {
        $this->teamID = $teamID;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.team-renew-join-code');
    }
}
