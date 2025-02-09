<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShippedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $order;

    public $site_logo;
    public $subject;
    public function __construct($order)
    {
        $this->order = $order;
        $setting = Setting::first();
        $this->site_logo = $setting->site_logo;
        $this->subject = 'Your Order has been Shipped ';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Your Order has been Shipped';
        return $this->from('customerservice@souqkahraba.com', config('global.used_app_name', 'Tawredaat'))
            ->markdown('User.mails.OrderSShipped')->subject($subject);
    }
}
