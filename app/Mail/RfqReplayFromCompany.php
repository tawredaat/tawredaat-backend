<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RfqReplayFromCompany extends Mailable
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
        $this->subject = 'RFQ Reply – Check it quickly';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'RFQ Reply – Check it quickly';
        return $this->from('customerservice@souqkahraba.com', config('global.used_app_name', 'Tawredaat'))->markdown('User.mails.RfqreplayFromCompany')->subject($subject);
    }
}