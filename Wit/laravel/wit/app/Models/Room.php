<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function listRooms(){
        return $this->hasMany('App\Models\ListRoom');
    }

    public function RoomChat(){
        return $this->hasMany('App\Models\RoomChat');
    }

    public function roomUsers(){
        return $this->hasMany('App\Models\RoomUser');
    }

    public function roomTags(){
        return $this->hasMany('App\Models\RoomTag');
    }

    public function roomImages(){
        return $this->hasMany('App\Models\RoomImage');
    }

    public function answers(){
        return $this->hasOne('App\Models\Answer');
    }

}
