<?php

namespace App\Rules;

use App\Models\Order;
use App\User;
use Illuminate\Contracts\Validation\Rule;

class ValidateBillingEmail implements Rule
{
    public $order_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
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
        $user = User::where('email', $value)->first();

        if (is_null($user)) {
            return false;
        }

        $order = Order::find($this->order_id);

        if (is_null($order->user)) {
            return false;
        }

        return $order->user->email == $value;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.invalid_billing_email');
    }
}
