<?php

namespace App\Listeners;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Events\UserSessionChanged;
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
    public function handle(UserSessionChanged $event)
    {
        $room = new Room;
        $room_id = $event->room_id;
        $auth_id = Auth::id();
       //$room->find($room_id)->roomUsers()->syncWithoutDetaching($auth_id);
        if ($room->find($room_id)->roomUsers->doesntContain($auth_id)) {
            $room->find($room_id)->roomUsers()->syncWithoutDetaching($auth_id);
            //$room->find($room_id)->roomUsers()->detach($auth_id);
        }else{
            $room->find($room_id)->roomUsers()->updateExistingPivot($auth_id,['entered_at' => Carbon::now()]);
        }
    }
}
