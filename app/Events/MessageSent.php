<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    public $user;
    public $message;
    public $product_id;

    public function __construct($user, $message, $product_id)
    {
        $this->user = $user;
        $this->message = $message;
        $this->product_id = $product_id;
    }

    public function broadcastOn()
    {
        return new Channel('auction-chat.' . $this->product_id);
    }

    public function broadcastAs()
    {
        return 'MessageSent';
    }
}

