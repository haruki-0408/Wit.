<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomChat extends Model
{
    use HasFactory;

    protected $table = 'room_chat';//  モデルもテーブル名も同じく単数形だから指定している

    public $timestamps = false;

    protected $guarded = [
        'id',
        'room_id',
        'user_id',
    ];

    protected $fillable = [
        'message',
        'postfile',
    ];

    public function room(){
        return $this->belongsTo('App\Models\Room');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }


}
