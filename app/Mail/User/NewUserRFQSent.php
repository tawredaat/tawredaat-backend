<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserRFQSent extends Mailable
{
    use Queueable, SerializesModels;

    public $user_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'طلب عرض أسعار';

        return $this->from('info@tawredaat.com',
            config('global.used_app_name', 'Tawredaat'))
            ->markdown('User.mails.new_user_rfq_sent')
            ->with(['subject' => $subject])
            ->subject($subject);
    }
}
