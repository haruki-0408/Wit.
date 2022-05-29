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

    protected $hidden = [
        'created_at',
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function favoriteUsers(){
        return $this->belongsTo('App\Models\User');
    }

    public function addListUser($user_id)
    {
        $list_user = new ListUser;
        $list_user->user_id = Auth::id();
        $list_user->favorite_user_id = $user_id ;
        $list_user->save();

        return 'リストにユーザーを追加しました';
    }
}
