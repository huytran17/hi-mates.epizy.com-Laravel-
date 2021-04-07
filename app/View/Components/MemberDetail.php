<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MemberDetail extends Component
{
    public $member;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($member)
    {
        $this->member = json_decode($member);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.member-detail');
    }
}
