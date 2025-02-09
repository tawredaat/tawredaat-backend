<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
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

        $this->subject = 'Thank you for shopping on souqKahraba.com! ';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Thank you for shopping on souqKahraba.com!';
        return $this->from('customerservice@souqkahraba.com',
            config('global.used_app_name', 'Tawredaat'))
            ->markdown('User.mails.OrderPlaced')->subject($subject);
    }
}
