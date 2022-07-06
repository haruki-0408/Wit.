<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
//uuidを導入するために変更する
use GoldSpecDigital\LaravelEloquentUUID\Foundation\Auth\User as Authenticatable;
use phpDocumentor\Reflection\PseudoTypes\LowercaseString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static $rules = [
        'name' => 'required|max:20',
        'email' => 'required|email',
        'password' => 'required',
        'profille_message' => 'required|max:500',
    ];

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
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'profile_message',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rooms()
    {
        return $this->hasMany('App\Models\Room','user_id');
    }

    public function listUsers()
    {
        return $this->belongsToMany('App\Models\User', 'list_users', 'user_id', 'favorite_user_id');
    }


    public function listRooms()
    {
        return $this->belongsToMany('App\Models\Room', 'list_rooms', 'user_id', 'room_id');
    }

    public function roomChat()
    {
        return $this->belongsToMany('App\Models\Room','room_chat','user_id');
    }

    public function roomUsers()
    {
        return $this->belongsToMany('App\Models\Room','room_users','user_id','room_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }

    //ユーザーの名前検索
    public function scopeSearchUserName($query, $user_name)
    {
        return $query->whereRaw("name LIKE CAST(? as CHAR) COLLATE utf8mb4_unicode_ci", ['%' . $user_name . '%']);
    }

    public static function buttonTypeJudge($user_id, $search_query = null, $list_query = null)
    {
        $bit_flag = 0b00; //２進数として扱うときは先頭に0bを付与
        if (isset($user_id)) {
            $auth_id = Auth::id();
            $user = User::find($auth_id);

            if (isset($search_query)) {
                //seachUser()から飛んできたとき
                if ($search_query->orderBy('id', 'desc')->value('id') == $user_id) {
                    $no_get_more = true;
                } else {
                    $no_get_more = false;
                }
            } else if (isset($list_query)) {
                //getListUser()から飛んできたときはテーブルjoinするのでvalue('id')だと、どのidか曖昧になるため記載方法変更
                if ($list_query->orderBy('list_users.id', 'asc')->value('users.id') == $user_id) {
                    $no_get_more = true;
                } else {
                    $no_get_more = false;
                }
            } else {
                $no_get_more = false;
            }

            //ユーザーがauthユーザーかどうか判定
            if ($user_id == $auth_id) {
                $bit_flag = $bit_flag | 0b00;
            } elseif ($user->listUsers()->where('favorite_user_id', $user_id)->exists()) {
                //ユーザーがリストに登録されていたら
                $bit_flag = $bit_flag | 0b10;
            } else {
                //ユーザがリストに登録されていなかったら
                $bit_flag = $bit_flag | 0b01;
            }

            $type = decbin($bit_flag);
            //decbinは２進数として扱う
            return ['type' => $type, 'no_get_more' => $no_get_more];
        }
    }

    public static function addListUser($user_id)
    {
        $auth_id = Auth::id();
        $decrypted_user_id = Crypt::decrypt($user_id);
        $user = User::find($auth_id);
        if ($user->listUsers()->where('favorite_user_id',$decrypted_user_id)->exists()){
            $message_type = 10;
            return $message_type;
        } elseif (User::where('id', $decrypted_user_id)->exists()) {
            $user->listusers()->syncWithoutDetaching($decrypted_user_id);
            $message_type = 1;
            return $message_type;
        }else{
            $message_type = 0;
            return $message_type;
        }
    }

    public static function removeListUser($user_id)
    {
        $auth_id = Auth::id();
        $decrypted_user_id = Crypt::decrypt($user_id);
        $user = User::find($auth_id);
        if ($user->listUsers()->where('favorite_user_id',$decrypted_user_id)->doesntExist()){
            $message_type = 10;
            return $message_type;
        } elseif (User::where('id', $decrypted_user_id)->exists()) {
            //$list_user = new ListUser;
            //$list_user->where('user_id', $auth_id)->where('favorite_user_id',$decrypted_user_id)->delete();
            $user->listUsers()->detach($decrypted_user_id);
            $message_type = 1;
            return $message_type;
        }else{
            $message_type = 0;
            return $message_type;
        }
    }

}
