<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Rorecek\Ulid\HasUlid;
use App\Models\Tag;
use App\Models\RoomTag;
use Illuminate\Support\Facades\Auth;

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

    public function scopeSearchRoomName($query, $room_word)
    {
        if (isset($room_word)) {
            $keyword = '%' . addcslashes($room_word, '%_\\') . '%';
            return $query->whereRaw("title LIKE CAST(? as CHAR) COLLATE utf8mb4_general_ci", [$keyword])
                ->orWhereRaw("description LIKE CAST( ? as CHAR) COLLATE utf8mb4_general_ci", [$keyword]);
        }
    }
    //照合順序　utf8mb4_general_ci ひらがなとカタカナを区別する　　　大文字と小文字は区別しない
    //照合順序　utf8mb4_unicode_ci ひらがなとカタカナを区別しない　大文字と小文字も区別しない

    //Roomの鍵あり検索
    public function scopeSearchRoomPassword($query)
    {
        return $query->whereNotNull('password');
    }

    public function scopeSearchRoomId($query, $room_id)
    {
        if (isset($room_id)) {
            return $query->whereRaw('id = ?', [$room_id]);
        }
    }

    public function scopeSearchTagName($query, $tag_name)
    {
        if (isset($tag_name)) {
            //$keyword = addcslashes($tag_name, '%_\\');
            //dd($tag_name,$keyword);
            return $query->whereHas('roomTags.tag', function ($tag) use ($tag_name) {
                $tag->whereRaw('name = CAST(? as CHAR) COLLATE utf8mb4_general_ci', [$tag_name]);
            });
        }
    }

    public static function buttonTypeJudge($room_id)
    {
        $user_id = Auth::id();
        $bit_flag = 0b000; //２進数として扱うときは先頭に0bを付与
        if (isset($room_id)) {
            
            //部屋の作成者かどうか判定
            if (Room::where('id', $room_id)->value('user_id') == $user_id) {
                $bit_flag = $bit_flag | 0b100;
            }

            //部屋がリスト登録されているかどうか判定
            if (ListRoom::where('user_id', $user_id)->where('room_id', $room_id)->exists()) {
                $bit_flag = $bit_flag | 0b010;
            }

            //部屋にパスワードがあるかどうか判定
            if ((Room::where('id', $room_id)->value('password'))) {
                $bit_flag = $bit_flag | 0b001;
            }

            $type = decbin($bit_flag);
            //decbinは２進数として扱う
            return $type;
        }
    }
}
