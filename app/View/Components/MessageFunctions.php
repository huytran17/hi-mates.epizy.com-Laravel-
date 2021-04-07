<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MessageFunctions extends Component
{
    public $teamMaker, $teamID;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($teamMaker, $teamID)
    {
        $this->teamMaker = $teamMaker;

        $this->teamID = $teamID;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.message-functions');
    }
}
