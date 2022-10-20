<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'id',
    ];

    public $timestamps = false;

    protected $fillable = [
        'name',
        'number',
    ];

    protected $hidden = [
        'id',
        'created_at',
    ];

    public function rooms(){
        return $this->belongsToMany('App\Models\Room','room_tags');
    }
}
