<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Penutupan;

class ComplaintClosed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $penutupan;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Penugasan $mPenutupan)
    {
        $this->penutupan = $mPenutupan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
