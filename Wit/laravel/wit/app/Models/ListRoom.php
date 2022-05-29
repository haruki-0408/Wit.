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

    public function room(){
        return $this->belongsTo('App\Models\Room');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public static function addListRoom($room_id)
    {
        $list_room = new ListRoom;
        $list_room->user_id = Auth::id();
        $list_room->room_id = $room_id ;
        $list_room->save();

        return 'リストにルームを追加しました';
    }

}
