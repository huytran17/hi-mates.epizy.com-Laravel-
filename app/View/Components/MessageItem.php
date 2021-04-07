<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MessageItem extends Component
{
    public $msg;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($msg)
    {
        $this->msg = json_decode($msg);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.message-item');
    }
}
