<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GetListedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $companyName;

    public $site_logo;
    public $subject;
    public function __construct($companyName)
    {
        $this->companyName = $companyName;
        $setting = Setting::first();
        $this->site_logo = $setting->site_logo;
        $this->subject = 'Your Company Listing Request Received Successfully ';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Your Company Listing Request Received Successfully ';
        return $this->from('customerservice@souqkahraba.com', config('global.used_app_name', 'Tawredaat'))->markdown('User.mails.getListed')->subject($subject);
    }
}