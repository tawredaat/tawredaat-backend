<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user_first_name;

    public $site_logo;
    public $subject;

    public function __construct($user_first_name)
    {
        $this->user_first_name = $user_first_name;
        $setting = Setting::first();
        $this->site_logo = $setting->site_logo;
        $this->subject = 'Welcome to Souqkahraba.com!';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Welcome to Souqkahraba.com!';
        return $this->from('customerservice@souqkahraba.com', config('global.used_app_name', 'Tawredaat'))->markdown('User.mails.userRegistration')->subject($subject);
    }
}