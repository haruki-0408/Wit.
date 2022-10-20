<?php

namespace App\Listeners;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Events\UserEntered;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BroadcastUserEnterNotification
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
    public function handle(UserEntered $event)
    {
        $room = new Room;
        $room_id = $event->room_id;
        $auth_id = Auth::id();
        if ($room->where('id', $room_id)->exists()) {
            if ($room->find($room_id)->roomUsers->doesntContain($auth_id)) {
                $room->find($room_id)->roomUsers()->syncWithoutDetaching($auth_id);
                $room->find($room_id)->roomUsers()->updateExistingPivot($auth_id, ['in_room' => true]);
            } else {
                $room->find($room_id)->roomUsers()->updateExistingPivot($auth_id, ['in_room' => true,'entered_at' => Carbon::now()]);
            }
        }
    }
}
