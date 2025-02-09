<?php

namespace App\Mail\Admin\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $user_name;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->user_name = "";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = ' تم استلام طلب جديد';

        return $this->from(config('global.used_sent_from_email', 'info@tawredaat.com'),
            config('global.used_app_name', 'Tawredaat'))
            ->markdown('User.mails.admin.order.received')
            ->with(['subject' => $subject, 'order' => $this->order])
            ->subject($subject);
    }
}
