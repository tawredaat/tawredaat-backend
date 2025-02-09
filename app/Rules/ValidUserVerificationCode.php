<?php

namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;
use App\Models\UserVerification;

class ValidUserVerificationCode implements Rule
{
    protected $userId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
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
        $checkCode = UserVerification::where([ ['user_id', $this->userId],['code',$value] ])->first();
        if ($checkCode)
            return true;
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  __('auth.invalidCode');
    }
}
