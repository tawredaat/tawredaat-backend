<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// To user, RFQ was sent
class UserRfqSendConfirm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user_name;

    public function __construct($user_name)
    {
        $this->user_name = $user_name;
        $this->subject = 'Thank You – Your RFQ has been sent Successfully';

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Thank You – Your RFQ has been sent Successfully';

        return $this->from('customerservice@souqkahraba.com',
            config('global.used_app_name', 'Tawredaat'))
            ->markdown('User.mails.userRfqSent')->subject($subject);
    }
}
