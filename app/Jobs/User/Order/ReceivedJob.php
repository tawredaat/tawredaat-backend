<?php

namespace App\Jobs\User\Order;

use App\Mail\User\Order\OrderReceived;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ReceivedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
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
        info('ReceivedJob is called at' . date('d-m-Y H:i:s') . ' (not daylight saving time)');
        Mail::to($this->order->user->email)->queue(new OrderReceived($this->order));
        info('OrderReceived Mail has finished at' . date('d-m-Y H:i:s') . ' (not daylight saving time)');
    }

    public function failed(Throwable $exception)
    {
        info('ReceivedJob has failed, exception messages is ' . $exception->getMessage()
            . ' ' . ',exception code=' . $exception->getCode());
    }
}
