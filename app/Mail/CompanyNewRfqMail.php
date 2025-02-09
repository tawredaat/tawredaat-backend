<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyNewRfqMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $companyName;
    public $rfq_id;
    public $site_logo;
    public $subject;
    public function __construct($companyName, $rfq_id)
    {
        $this->companyName = $companyName;
        $this->rfq_id = $rfq_id;
        $setting = Setting::first();
        $this->site_logo = $setting->site_logo;
        $this->subject = 'A New RFQ – Check it quickly ';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'A New RFQ – Check it quickly ';
        return $this->from('customerservice@souqkahraba.com', config('global.used_app_name', 'Tawredaat'))->markdown('User.mails.companyNewRfq')->subject($subject);
    }
}
