<?php

namespace App\Listeners;

use App\Events\UserExited;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BroadcastUserExitNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    
    public function handle(UserExited $event)
    {
        \Log::debug('Exit listener 発火');

        $room_id = $event->room_id;
        $user_id = $event->user_id;
        if (Room::where('id', $room_id)->exists()) {
            $room = Room::find($room_id);
            $room->roomUsers()->updateExistingPivot($user_id, ['exited_at' => Carbon::now()]);
        }
    }
}
