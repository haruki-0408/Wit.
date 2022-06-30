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

    protected $hidden = [
        'tag_id',
        'created_at',
        'updated_at',
    ];

    public function tags(){
        return $this->belongsToMany('App\Models\Tag','room_tags');
    }

    public function room(){
        return $this->belongsTo('App\Models\Room');
    }
    
    public function getTagInfo()
    {
        $items = $this->with('Tag')->get();
        return $items->tag->name ;
    }

}

