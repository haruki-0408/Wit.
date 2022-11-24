<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;

class RoomChat extends Pivot
{
    use HasFactory;

    protected $casts = [
        'choice' => 'boolean',
    ];

    //アクセサtoJsonされてもcreated_atを適切にJST表記するための処置
    protected function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timezone('Asia/Tokyo')->format('m/d H:i');
    } 
    
    protected function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timezone('Asia/Tokyo')->format('m/d H:i');
    } 
}
