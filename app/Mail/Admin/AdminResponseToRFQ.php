<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminResponseToRFQ extends Mailable
{
    use Queueable, SerializesModels;

    public $rfq;
    public $user;

    public function __construct($rfq)
    {
        $this->rfq = $rfq;
        $this->user = $rfq->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {

        $subject = 'تم الرد على طلب عرض السعر بنجاح رقم : ' . $this->rfq->id;

        return $this->from(config('global.used_sent_from_email'), config('global.used_website'))
            ->markdown('User.mails.admin_response_to_RFQ')
            ->subject($subject);
    }
}
