<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MessageFrame extends Component
{
    public $team;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($team)
    {
        $this->team = json_decode($team);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.message-frame');
    }
}
