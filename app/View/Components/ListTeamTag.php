<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListTeamTag extends Component
{
    public $teams;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($teams)
    {
        $this->teams = json_decode($teams);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.list-team-tag');
    }
}
