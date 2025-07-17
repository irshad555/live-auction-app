<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewBidPlaced implements ShouldBroadcast
{
    public $bid;

    public function __construct($bid)
    {
        $this->bid = $bid;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('auction.' . $this->bid->product_id);
    }

    public function broadcastWith()
    {
        return [
            'amount' => $this->bid->amount,
            'user' => $this->bid->user->name,
            'time' => $this->bid->created_at->toDateTimeString()
        ];
    }
}

