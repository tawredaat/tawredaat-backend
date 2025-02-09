<?php

namespace App\Events\Admin;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BrandCategoryEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $brand;
    public $categories;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($brand,$categories)
    {
        //
        $this->brand      = $brand;
        $this->categories = $categories;
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
