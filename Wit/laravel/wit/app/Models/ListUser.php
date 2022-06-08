<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ListUser extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'created_at',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function favoriteUsers()
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function addListUser($user_id)
    {
        $auth_id = Auth::id();
        $decrypted_user_id = Crypt::decrypt($user_id);
        if (ListUser::where('user_id',$auth_id)->where('favorite_user_id',$decrypted_user_id)->exists()){
            $message_type = 10;
            return $message_type;
        } elseif (User::where('id', $decrypted_user_id)->exists()) {
            $list_user = new ListUser;
            $list_user->user_id = $auth_id;
            $list_user->favorite_user_id = $decrypted_user_id;
            $list_user->save();
            $message_type = 1;
            return $message_type;
        }else{
            $message_type = 0;
            return $message_type;
        }
    }
}
