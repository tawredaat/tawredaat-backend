<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedNotifcationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order;

    public $subject;

    public function __construct($order)
    {
        $this->order = $order;

        $this->subject = 'New order #' . $this->order->id . ' has been placed on souqKahraba.com ! ';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'New order #' . $this->order->id . ' has been placed on souqKahraba.com ! ';
        return $this->from('customerservice@souqkahraba.com', 'Souqkahraba.com')->markdown('User.mails.OrderPlacedNotifcation')->subject($subject);
    }
}
