<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ListRoom extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_at',
    ];

    public $timestamps = false;

    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function addListRoom($room_id)
    {
        $auth_id = Auth::id();
        if (isset($room_id)) {
            if (ListRoom::where('user_id', $auth_id)->where('room_id', $room_id)->exists()) {
                $message_type = 0;
            } else if (Room::where('id', $room_id)->exists()) {
                $list_room = new ListRoom;
                $list_room->user_id = Auth::id();
                $list_room->room_id = $room_id;
                $list_room->save();
                $message_type = 1;
            } else {
                $message_type = 2;
            }
        } else {
            $message_type = 3;
        }

        return $message_type;
    }
}
