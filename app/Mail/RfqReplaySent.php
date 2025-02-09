<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RfqReplaySent extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user_first_name;

    public $site_logo;

    public $company_name;
    public $subject;
    public function __construct($user_first_name, $company_name)
    {
        $this->user_first_name = $user_first_name;
        $this->company_name = $company_name;
        $setting = Setting::first();
        $this->site_logo = $setting->site_logo;
        $this->subject = 'Thank You – Your Reply has been sent Successfully';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Thank You – Your Reply has been sent Successfully';
        return $this->from('customerservice@souqkahraba.com', config('global.used_app_name', 'Tawredaat'))->markdown('User.mails.RfqreplaySent')->subject($subject);
    }
}