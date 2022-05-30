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
        $decrypted_user_id = Crypt::decrypt($user_id);
        if (User::where('id', $decrypted_user_id)->exists()) {
            $list_user = new ListUser;
            $list_user->user_id = Auth::id();
            $list_user->favorite_user_id = $decrypted_user_id;
            $list_user->save();

            return 'リストにユーザーを追加しました';
        }else{
            return 'そのユーザは存在しません';
        }
    }
}
