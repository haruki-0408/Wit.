<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    protected $casts = [
        'in_room' => 'boolean',
    ];

    protected function getEnteredAtAttribute($value)
    {
        return Carbon::parse($value)->timezone('Asia/Tokyo')->format('m/d H:i');
    }

    protected function getExitedAtAttribute($value)
    {
        if ($value == null) {
            return null;
        } else {
            return Carbon::parse($value)->timezone('Asia/Tokyo')->format('m/d H:i');
        }
    }

    public static function countOnlineUsers($room_id)
    {
        $room_users = Room::find($room_id)->roomUsers;
        $count = 0;

        foreach ($room_users as $user) {
            if ($user->pivot->in_room == 1) {
                $count++;
            }
        }

        return $count;
    }

    public static function countOnlineOthers($room_id)
    {
        $room = new Room;
        $room_user_id = $room->find($room_id)->user_id;
        $room_others = $room->find($room_id)->roomUsers->except(['id', Auth::id()])->except(['id', $room_user_id]);
        $other_count = 0;
        foreach ($room_others as $other) {
            if ($other->pivot->in_room == 1) {
                $other_count++;
            }
        }

        return $other_count;
    }
}
