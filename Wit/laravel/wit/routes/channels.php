<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Room;
use App\Models\RoomUser;
use Illuminate\Support\Facades\Auth;

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
    $room_user_id = $room->find($room_id)->user_id;

    //ルームの管理者は数に入れない
    $count_online_users = $room->find($room_id)->roomUsers->except(['id',$room_user_id])->count();
    $count_in_room = $user->inRoomCount->count();
    $ban_check = $room->find($room_id)->roomBans->contains($user->id);

    if($ban_check){
        return false;
    }

    if($count_in_room != 1){
        return false;
    }

    if($room->find($room_id)->posted_at !== null){
        return false;
    }

    if($count_online_users > 10 && $user->id !== Auth::id()){
        return false;
    }

    return $user;
});
