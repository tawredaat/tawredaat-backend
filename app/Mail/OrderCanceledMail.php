<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCanceledMail extends Mailable
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
        $this->subject = 'Your Order Status has been Changed! ';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Your Order Status has been Changed!';
        return $this->from('customerservice@souqkahraba.com',
            config('global.used_app_name', 'Tawredaat'))
            ->markdown('User.mails.OrderCanceled')->subject($subject);
    }
}
