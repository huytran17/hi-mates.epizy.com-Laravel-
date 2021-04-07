<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckRetypePassword implements Rule
{
    protected $new_pwd;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($new_pwd)
    {
        $this->new_pwd = $new_pwd;
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
        return $value === $this->new_pwd;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Mật khẩu nhập lại không khớp';
    }
}
