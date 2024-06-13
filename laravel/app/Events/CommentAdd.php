<?php

namespace App\Events;

use Illuminate\Broadcasting\{Channel, PresenceChannel, PrivateChannel};
use Illuminate\Contracts\Broadcasting\{ShouldBroadcast, ShouldBroadcastNow};
use Illuminate\Broadcasting\{InteractsWithSockets, InteractsWithBroadcasting};
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class CommentAdd implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithBroadcasting, SerializesModels;


    public function broadcastOn()
    {
        return [
            new Channel('Comment')
        ];
    }


    public function broadcastConnections()
    {
        return [
            'pusher'
        ];
    }
}
