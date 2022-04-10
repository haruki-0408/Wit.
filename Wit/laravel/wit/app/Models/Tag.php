<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public static $rules =[
        'name'=>'required|max:20|unique:member,name',
        'number'=>'filled|integer',
    ];
    
    protected $guarded = [
        'id',
    ];

    public $timestamps = false;

    protected $fillable = [
        'name',
        'number',
    ];

    protected $hidden = [
        'created_at',
    ];

    public function roomTags(){
        return $this->hasMany('App\Models\RoomTag');
    }
}
