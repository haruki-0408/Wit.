<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room_id;
    public $user;
    public $message;
    public $auth_user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($room_id, User $user,$auth_user,$message)
    {
        $this->room_id = $room_id;
        $this->user = $user;
        $this->message = $message;
        $this->auth_user = $auth_user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //\Log::debug("{$this->user->name}: {$this->message} in {$this->room_id}");
        //return new PresenceChannel('send-message.'.$this->room_id);
        return new PresenceChannel('room-user-notifications.'.$this->room_id);
    }
}
