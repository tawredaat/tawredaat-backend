<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeNewRegisteredUser extends Mailable
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
        $subject = 'مرحبا بكم في توريدات دوت كوم!';

        return $this->from(config('global.used_sent_from_email', 'info@tawredaat.com'),
            config('global.used_app_name', 'Tawredaat'))
            ->markdown('User.mails.welcome_new_registered_user')
            ->with(['subject' => $subject])
            ->subject($subject);
    }
}
