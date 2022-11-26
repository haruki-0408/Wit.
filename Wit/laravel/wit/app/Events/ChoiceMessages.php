<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChoiceMessages implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room_id;
    public $user_id;
    public $room_chat_array;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($room_id,$user_id,$room_chat_array)
    {
        $this->room_id = $room_id;
        $this->user_id = $user_id;
        $this->room_chat_array = $room_chat_array;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('room-user-notifications.' . $this->room_id);
    }
}
