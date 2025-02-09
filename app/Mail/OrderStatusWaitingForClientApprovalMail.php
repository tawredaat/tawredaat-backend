<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusWaitingForClientApprovalMail extends Mailable
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
    public $user_name;

    public function __construct($order)
    {
        $this->order = $order;
        $this->user_name = $order->user->name;
        $this->subject = 'Your order status has been changed ';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function  build()
    {
        // $data = ['order' => $this->order,
        //     'user_name' => $this->user_name];

        // return view('User.mails.waiting_for_client_approval_status')->with($data);

        $subject = 'Your order status has been changed';

        return $this->from('customerservice@souqkahraba.com',
            config('global.used_app_name', 'Tawredaat'))
            ->markdown('User.mails.waiting_for_client_approval_status')->subject($subject);
    }
}