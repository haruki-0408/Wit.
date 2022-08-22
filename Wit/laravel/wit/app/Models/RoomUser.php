<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;

class RoomUser extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'in_room',
        'entered_at',
        'exited_at',
    ];

    protected $dates = [
        'entered_at',
        'exited_at',
    ];

    protected $casts =[
        'in_room' => 'boolean',
    ];

    public static function countOnlineUsers($room_id)
    {
        $room_users = Room::find($room_id)->roomUsers;
        $count = 0;

        foreach ($room_users as $user) {
            if($user->pivot->in_room == 1){
                $count++;
            }
        }
        
        return $count;
    }
    
    public static function countOnlineOthers($room_id)
    {
        $room = new Room;
        $room_others = $room->find($room_id)->roomUsers->except(['id',Auth::id()]);
        $other_count = 0;
        foreach ($room_others as $other) {
            if($other->pivot->in_room == 1){
                $other_count++;
            }
        }
     
        return $other_count;
    }
}