<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Room;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('room-user-notifications.{room_id}', function ($user, $room_id) {
    $room = new Room;
    if($user->roomUsers->contains($room_id)&&($room->find($room_id)->roomBans->doesntContain($user->id)) ){
        //$user->id = Crypt::encrypt($user->id);
        return $user;
        //return ['id'=>Crypt::encrypt($user->id),'name'=>$user->name,'profile_image'=>$user->profile_image];
    }else{
        return false;
    }
});
