<?php

namespace App\Jobs\User\Order;

use App\Mail\User\Order\OrderConfirming;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ConfirmingJob implements ShouldQueue
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
        info('ConfirmingJob is called at' . date('d-m-Y H:i:s') . ' (not daylight saving time)');
        Mail::to($this->order->user->email)->queue(new OrderConfirming($this->order));
        info('OrderConfirming Mail has finished at' . date('d-m-Y H:i:s') . ' (not daylight saving time)');
    }

    public function failed(Throwable $exception)
    {
        info('ConfirmingJob has failed, exception messages is ' . $exception->getMessage()
            . ' ' . ',exception code=' . $exception->getCode());
    }
}
