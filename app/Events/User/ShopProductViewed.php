<?php

namespace App\Events\User;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShopProductViewed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $shop_product_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($shop_product_id)
    {
        $this->shop_product_id = $shop_product_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
