<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListRoom extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public $timestamps = false;

    public function room(){
        return $this->belongsTo('App\Models\Room');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
