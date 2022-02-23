<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListUser extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function favoriteUsers(){
        return $this->belongsTo('App\Models\User');
    }
}
