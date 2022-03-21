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


class RoomController extends Controller
{
    public function index()
    {
        $items = Room::all();
        return view('wit.ShowDatabase.showRoom', ['rooms' => $items]);
    }

    public function getFirstRoomInfo() //ページ読み込み時のルーム取得
    {
        $rooms = Room::with(['user', 'roomTags.tag'])->orderBy('id', 'desc')->take(5)->get();
        return $rooms;
    }

    public function getRoomInfo($room_id) //スクロール時のルーム取得
    {
        if (isset($room_id)) {
            $rooms = Room::with(['user', 'roomTags.tag'])->orderBy('id', 'desc')->where('id', '<', $room_id)->take(5)->get();
            //roomTags.tag でリレーションのリレーション先まで取得できた
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
                return redirect(route('enterRoom', [
                    'id' => $room_id,
                ]));
            } else {
                dd('passwordが間違っています');
            }
        }
    }

    public function enterRoom($room_id)
    {
        if (DB::table('rooms')->where('id', $room_id)->exists()) {
            $room_info = Room::with(['user', 'roomTags', 'roomChat', 'roomImages'])->find($room_id);
            return view('wit.room', ['room_info' => $room_info]);
        } else {
            return view('wit.room-error', ['room_id' => $room_id]);
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
            $img = $image_file->storeAs('roomImages/RoomID:' . $room_id, 'id' . $room_id . '_' . 'no' . $image_count . '.' . $extension, ['disk' => 'local']);
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
