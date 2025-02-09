<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// sent to admin on a new RFQ
class RFQSentNotifcationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $rfq;
    public $subject;
    public $user;

    public function __construct($rfq)
    {
        $this->user = $rfq->user;
        $this->rfq = $rfq;
        $this->subject = 'New RFQ #' . $this->rfq->id . ' has been sent on tawredaat.com.';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'New RFQ #' . $this->rfq->id . ' has been sent on tawredaat.com.';
        return $this->from('info@tawredaat.com',
            config('global.used_app_name', 'Tawredaat'))
            ->markdown('User.mails.RFQSentNotifcation')->subject($subject);
    }
}
