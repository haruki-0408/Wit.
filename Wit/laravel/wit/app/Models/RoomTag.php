<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTag extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function tag(){
        return $this->belongsTo('App\Models\Tag');
    }

    public function room(){
        return $this->belongsTo('App\Models\Room');
    }
}
