<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Room;
use App\Models\Tag;
use App\Models\RoomUser;
use App\Models\RoomImage;
use App\Models\RoomChat;
use App\Models\RoomTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class RoomController extends Controller
{

    public function index()
    {
        $items = Room::all();
        return view('wit.ShowDatabase.showRoom', ['rooms' => $items]);
    }

    public function getFirstRoomInfo() //ページ読み込み時のルーム取得
    {
        $rooms = Room::with(['user:id,name,profile_image', 'roomTags.tag:id,name,number'])->orderBy('id', 'desc')->take(5)->get();
        for ($i = 0; $i < 5; $i++) {
            /*if (isset($rooms[$i]->password)) {
               $room_data[$i] = [
                   'room_id' => $rooms[$i]->id,
                   'room_title' => $rooms[$i]->title,
                   'room_description' => $rooms[$i]->description,
                   'room_passwored' => '7891',
                   'user_id' => Crypt::encrypt($rooms[$i]->user_id),
                   'user_name' => $rooms[$i]->user->name,
                   'user_image' => $rooms[$i]->user->profile_image,
               ]
                for($j = 0; $j < count($rooms[$i]->room_tag); $j++){
                    //
                }


            }*/
            $rooms[$i]->user_id = Crypt::encrypt($rooms[$i]->user_id);


            if (isset($rooms[$i]->password)) {
                $rooms[$i]->password = '7891';
            }
        }
        return $rooms;
    }

    public function getRoomInfo($room_id) //スクロール時のルーム取得
    {
        if (isset($room_id)) {
            $rooms = Room::with(['user:id,name,profile_image', 'roomTags.tag'])->orderBy('id', 'desc')->where('id', '<', $room_id)->take(5)->get();
            //roomTags.tag でリレーションのリレーション先まで取得できた
            for ($i = 0; $i < 5; $i++) {
                $rooms[$i]->user_id = Crypt::encrypt($rooms[$i]->user_id);

                if (isset($rooms[$i]->password)) {
                    $rooms[$i]->password = '7891';
                }
            }

            return $rooms;
        }
    }

    public function authRoomPassword(Request $request)
    {
        $room_id = $request->room_id;
        $room = Room::find($room_id);
        $room_password = $room->password;

        if (isset($request->enterPass) && isset($room_password)) {
            if (Hash::check($request->enterPass, $room_password)) {
                $room_info = Room::with(['user:id,name,profile_image', 'roomTags:id,room_id,tag_id', 'roomChat:id,room_id,user_id,message',])->find($room_id);
                $count_image_data = RoomImage::where('room_id', $room_id)->get('image')->count();
                session()->put('auth_room_id', $room_id);
                return view('wit.room', [
                    'room_info' => $room_info,
                    'count_image_data' => $count_image_data,
                ]);
            } else {
                return back()->with('flashmessage', 'パスワードが違います');
            }
        } else {
            return back()->with('flashmessage', 'パスワードが不正入力されています');
        }
    }

    public function enterRoom($room_id)
    {
        if (DB::table('rooms')->where('id', $room_id)->exists()) {
            $room_info = Room::with(['user:id,name,profile_image', 'roomTags:id,room_id,tag_id', 'roomChat:id,room_id,user_id,message',])->find($room_id);
            $count_image_data = RoomImage::where('room_id', $room_id)->get('image')->count();
            
            if ($room_info->password == null) {
                return view('wit.room', [
                    'room_info' => $room_info,
                    'count_image_data' => $count_image_data,
                ]);
            } else {
                return redirect('home')->with('flashmessage', 'パスワード付きのルームです');
            }
        } else {
            return view('wit.room-error', ['room_id' => $room_id]);
        }
    }

    //ルーム画像だけは別のメソッドで返す。　不正アクセス対策
    public function showRoomImage($room_id, $number)
    {
        $room = Room::find($room_id)->only("password");

        if (is_null($room['password'])) {
        
            $room_image = RoomImage::where('room_id', $room_id)->offset($number)->first('image');

            if (!Storage::exists($room_image->image)) {
                abort(404);
            }

            return response()->file(Storage::path($room_image->image));
        } else if (session()->get('auth_room_id') == $room_id) {
            $room_image = RoomImage::where('room_id', $room_id)->offset($number)->first('image');
            
            if (!Storage::exists($room_image->image)) {
                abort(404);
            }

            return response()->file(Storage::path($room_image->image));
        } else {
            abort(404);
        }
    }


    public function userGet()
    {
        $items = RoomUser::with('User')->get();
        return view('wit.ShowDatabase.showRoomUser', ['room_users' => $items]);
    }

    public function getUser()
    {
        $users = User::select('name', 'email')->get();
        return $users;
    }

    public function imageGet()
    {
        $items = RoomImage::with('Room')->get();
        return view('wit.ShowDatabase.showRoomImage', ['room_images' => $items]);
    }

    public function chatGet()
    {
        $items = RoomChat::with('User')->with('Room')->get();
        return view('wit.ShowDatabase.showRoomChat', ['room_chat' => $items]);
    }

    public function storeImage($image_file, $image_count, $room_id)
    {
        if (isset($image_file)) {
            //拡張子を取得
            $extension = $image_file->getClientOriginalExtension();
            //画像を保存して、そのパスを$imgに保存　第三引数に'local'を指定
            $img = $image_file->storeAs('roomImages/RoomID:' . $room_id, 'no' . $image_count . '.' . $extension, ['disk' => 'local']);
            return $img;
        }
    }

    public function storeTag($match)
    {
        $tag = Tag::UpdateOrCreate(['name' => $match], ['name' => $match, 'number' => DB::raw('number + 1')]);
        return $tag;
    }


    public function create(Request $request)
    {
        //$this->validate($request, Room::$rules);
        //$this->validate($request, Tag::$rules);

        $room = new Room;

        //roomsテーブルへ保存
        $room->user_id =  Auth::user()->id;
        $room->title = $request->title;
        $room->description = $request->description;
        if ($request->has('createPass')) {
            $room->password = Hash::make($request->createPass);
        };
        $room->save();

        //room_chatテーブルへ保存
        $room_chat = new RoomChat;
        $room_chat->room_id = $room->id;
        $room_chat->user_id = $room->user_id;
        $room_chat->message = $room->description;
        $room_chat->save();

        //room_imagesテーブルへ保存
        if ($request->has('roomImages')) {
            foreach ($request->file("roomImages") as $index => $roomImage) {
                $image_count = $index;
                $room_image = new RoomImage;
                $room_image->room_id = $room->id;
                $room_image->image = $this->storeImage($roomImage, $image_count, $room->id);
                $room_image->save();
            }
        }

        if ($request->has('tag')) {
            preg_match_all('/([a-zA-Z0-9ぁ-んァ-ヶー-龠%；　 -]+);/u', $request->tag, $matches);
            foreach ($matches[1] as $match) {
                $tag = $this->storeTag($match);
                $room_tag = new RoomTag;
                $room_tag->room_id = $room->id;
                $room_tag->tag_id = $tag->id;
                $room_tag->save();
            }
        }
        return redirect(route('enterRoom', [
            'id' => $room->id,
        ]));
    }
}
