<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Model;
use Rorecek\Ulid\HasUlid;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class Room extends Model
{
    use HasFactory, HasUlid;

    public $incrimenting = false;

    protected $keyType = 'string';

    const UPDATED_AT = NULL;

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
        'password',
        'posted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
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
        return $this->belongsToMany('App\Models\User', 'list_rooms', 'user_id', 'room_id');
    }

    public function roomChat() //ここだけChatsとは言わないので複数形の意味だけどChat
    {
        return $this->belongsToMany('App\Models\User', 'room_chat', 'room_id')->withPivot('message', 'postfile', 'created_at')->orderBy('room_chat.id', 'asc');
    }

    public function roomUsers()
    {
        return $this->belongsToMany('App\Models\User', 'room_users', 'room_id', 'user_id')->using('App\Models\RoomUser')->withPivot('in_room','entered_at', 'exited_at');
    }

    public function roomBans()
    {
        return $this->belongsToMany('App\Models\User', 'room_bans', 'room_id', 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'room_tags');
    }

    public function roomImages()
    {
        return $this->hasMany('App\Models\RoomImage');
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

    public function scopeSearchPostRoom($query)
    {
        return $query->whereNotNull('posted_at');
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
            return $query->whereHas('tags', function ($tag) use ($tag_name) {
                $tag->whereRaw('name = CAST(? as CHAR) COLLATE utf8mb4_general_ci', [$tag_name]);
            });
        }
    }

    public static function checkExpiredRoom($room_id)
    {
        $created_at = Room::find($room_id)->created_at;
        $carbon = new Carbon($created_at);
        $expired_at = $carbon->addDays(7);
        return $expired_at <= Carbon::now();
    }

    public static function getRoomExpiredTime($room_id)
    {
        $room = new Room;
        $created_at = $room->find($room_id)->created_at;
        $carbon = new Carbon($created_at);
        $expired_at = $carbon->addDays(7);
        $diff = $expired_at->diffInHours(Carbon::now());
        return $diff;
    }

    public static function checkRoomAccess($user_id, $room_id)
    {
        $room = new Room;
        if ($room->find($room_id)->roomBans->contains($user_id) || $room->find($room_id)->posted_at != null) {
            return true;
        } else {
            return false;
        }
    }

    public static function buttonTypeJudge($room_id, $search_query = null, $list_query = null)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);

        $bit_flag = 0b0000; //２進数として扱うときは先頭に0bを付与
        if (isset($room_id)) {
            if (isset($search_query)) {
                //getPostRoom(),seachRoom()から飛んできたとき
                if ($search_query->orderBy('id', 'asc')->value('id') == $room_id) {
                    $no_get_more = true;
                } else {
                    $no_get_more = false;
                }
            } else if (isset($list_query)) {
                //getListRoom()から飛んできたときはテーブルjoinするのでvalue('id')だと、どのidか曖昧になるため記載方法変更
                if ($list_query->orderBy('list_rooms.id', 'asc')->value('rooms.id') == $room_id) {
                    
                    $no_get_more = true;
                } else {
                    $no_get_more = false;
                }
            } else {
                //getRoomInfo()から飛んできたとき
                if (Room::orderBy('id', 'asc')->whereNull('posted_at')->value('id') == $room_id) {
                    $no_get_more = true;
                } else {
                    $no_get_more = false;
                }
            }

            //部屋の作成者なら
            if (Room::where('id', $room_id)->value('user_id') == $user_id) {
                $bit_flag = $bit_flag | 0b0100;
            }

            //部屋がリスト登録されているかどうか判定
            if ($user->listRooms()->where('room_id', $room_id)->exists()) {
                $bit_flag = $bit_flag | 0b0010;
            }

            //部屋にパスワードがあるかどうか判定
            if ((Room::where('id', $room_id)->value('password'))) {
                $bit_flag = $bit_flag | 0b0001;
            }

            $type = decbin($bit_flag);
            //decbinは２進数として扱う
            return ['type' => $type, 'no_get_more' => $no_get_more];
        }
    }

    public static function addListRoom($room_id)
    {
        $auth_id = Auth::id();
        $user = User::find($auth_id);
        if (isset($room_id)) {
            if ($user->listRooms()->where('room_id', $room_id)->exists()) {
                $message_type = 0;
            } else if (Room::where('id', $room_id)->exists()) {
                $user->listRooms()->syncWithoutDetaching($room_id);
                $message_type = 1;
            } else {
                $message_type = 2;
            }
        } else {
            $message_type = 3;
        }

        return $message_type;
    }

    public static function removeListRoom($room_id)
    {
        $auth_id = Auth::id();
        $user = User::find($auth_id);
        if (isset($room_id)) {
            if ($user->listRooms()->where('room_id', $room_id)->doesntExist()) {
                $message_type = 0;
            } else if (Room::where('id', $room_id)->exists()) {
                $user->listRooms()->detach($room_id);
                $message_type = 1;
            } else {
                $message_type = 2;
            }
        } else {
            $message_type = 3;
        }

        return $message_type;
    }
}
