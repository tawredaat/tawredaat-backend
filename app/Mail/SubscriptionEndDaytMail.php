<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionEndDaytMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $company_name;

    public $site_logo;
    public $subject;
    public function __construct($company_name)
    {
        $this->company_name = $company_name;
        $setting = Setting::first();
        $this->site_logo = $setting->site_logo;
        $this->subject = 'Your ' . config('global.used_app_name', 'Tawredaat') . ' Subscription has Ended';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Your ' . config('global.used_app_name', 'Tawredaat') . ' Subscription has Ended';
        return $this->from('customerservice@souqkahraba.com', config('global.used_app_name', 'Tawredaat'))->markdown('User.mails.CompanySubEndDay')->subject($subject);
    }
}