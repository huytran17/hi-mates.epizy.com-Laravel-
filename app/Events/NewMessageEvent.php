<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $team_id, $user_id, $message_item;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($team_id, $user_id, $message_item)
    {
        $this->team_id = $team_id;

        $this->user_id = $user_id;

        $this->message_item = $message_item;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('team.'. $this->team_id);
    }

    public function __destruct()
    {
        $this->team_id = null;

        $this->user_id = null;

        $this->message_item = null;
    }
}
