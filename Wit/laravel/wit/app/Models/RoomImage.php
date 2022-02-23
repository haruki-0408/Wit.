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
}
