<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class addSubscriptionToCompanyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $company_name;
    public $company_email;
    public $company_id;
    public $sub_name;
    public $code;
    public $site_logo;
    public $subject;

    public function __construct($company_name, $sub_name, $code, $company_email, $company_id)
    {
        $this->sub_name = $sub_name;
        $this->company_name = $company_name;
        $this->company_email = $company_email;
        $this->company_id = $company_id;
        $this->code = $code;
        $setting = Setting::first();
        $this->site_logo = $setting->site_logo;
        $this->subject = 'You have successfully Registered on ' . config('global.used_app_name', 'Tawredaat') . ' with [' . $this->sub_name . '] subscription';

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'You have successfully Registered on ' . config('global.used_app_name', 'Tawredaat') . ' with [' . $this->sub_name . '] subscription';
        return $this->from('customerservice@souqkahraba.com', config('global.used_app_name', 'Tawredaat'))->markdown('User.mails.addSubToCompany')->subject($subject);
    }
}
