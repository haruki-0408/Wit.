<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    public static $rules =[
        'image'=>'string',
        ];

    protected $guarded = [
        'id',
    ];

    public function room(){
        return $this->belongsTo('App\Models\Room');
    }

     //Roomの画像なし検索
     public function scopeSearchNoneRoomImage($query, $room_id)
     {
         if (!$query->where('id', '=', $room_id)->exist()) {
             return $query;
         }
     }
}
