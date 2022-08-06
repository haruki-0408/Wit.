<?php

namespace App\Listeners;

use App\Events\RemoveRoom;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BroadcastRemoveRoomNotification
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
    
    public function handle(RemoveRoom $event)
    {
        \Log::debug('消える飛行機雲僕たちは見送った');
        return redirect('home')->with('error-message','ルームID:'.$event->room_id.'は作成者により削除されました');
    }
}
