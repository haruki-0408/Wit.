<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Rorecek\Ulid\HasUlid;

class Room extends Model
{
    use HasFactory, HasUlid;

    //バリデーションルール
    public static $rules = [
        'title' => 'required|max:5',
        'description' => 'required|max:400',
    ];

    public $incrimenting = false;

    protected $keyType = 'string';


    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function listRooms()
    {
        return $this->hasMany('App\Models\ListRoom');
    }

    public function roomChat()
    {
        return $this->hasMany('App\Models\RoomChat');
    }

    public function roomUsers()
    {
        return $this->hasMany('App\Models\RoomUser');
    }

    public function roomTags()
    {
        return $this->hasMany('App\Models\RoomTag');
    }

    public function roomImages()
    {
        return $this->hasMany('App\Models\RoomImage');
    }

    public function answer()
    {
        return $this->hasOne('App\Models\Answer');
    }

    public function scopeSearchRoomName($query, $room_name)
    {
        return $query->whereRaw("title LIKE CAST(? as CHAR) COLLATE utf8mb4_unicode_ci", ['%' . $room_name . '%'])
                    ->orWhereRaw("description LIKE CAST(? as CHAR) COLLATE utf8mb4_unicode_ci", ['%' . $room_name . '%']);
    }

    //Roomの鍵あり検索
    public function scopeSearchRoomPassword($query)
    {
        return $query->whereNotNull('password');
    }

    public function scopeSearchRoomId($query,$room_id)
    {
        return $query->where('id' , '=' , '?' ,[$room_id]);
    }
}
