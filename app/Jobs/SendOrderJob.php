<?php

namespace App\Jobs;

use App\Mail\OrderPlacedMail;
use App\Mail\OrderPlacedNotifcationMail;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $order;
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->order->user->email)->send(new OrderPlacedMail($this->order));
        // nada@hypermedilabs.com
        Mail::to(config('global.used_client_email', 'mragab@souqkahraba.com'))
            ->send(new OrderPlacedNotifcationMail($this->order));

    }
}
