<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TeamUserExist implements Rule
{
    protected $teamuser, $uid, $tid;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($teamuser, $uid, $tid)
    {
        $this->teamuser = $teamuser;

        $this->uid = $uid;

        $this->tid = $tid;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !$this->teamuser->isExists($this->uid, $this->tid);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Hiện đang trong nhóm';
    }
}
