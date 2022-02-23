<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_message',
        'profile_image'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rooms(){
        return $this->hasMany('App\Models\Room');
    }

    public function listUsers(){
        return $this->hasMany('App\Models\ListUser');
    }

    public function favoriteUsers(){
        return $this->hasMany('App\Models\ListUser','favorite_user_id');
    }

    public function listRooms(){
        return $this->hasMany('App\Models\ListRoom');
    }

    public function roomChat(){
        return $this->hasMany('App\Models\RoomChat');
    }

    public function roomUsers(){
        return $this->hasMany('App\Models\RoomUser');
    }

    public function answers(){
        return $this->hasMany('App\Models\Answer');
    }
}
