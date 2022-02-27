<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Tag;
use App\Models\RoomUser;
use App\Models\RoomImage;
use App\Models\RoomChat;
use App\Models\RoomTag;
use Illuminate\Support\Facades\Auth;


class RoomController extends Controller
{
    public function index(Request $request)
    {
        $items = Room::all();
        return view('wit.ShowDatabase.showRoom', ['rooms' => $items]);
    }

    public function getRoomInfo($id)
    {
        $items = Room::with(['user', 'roomTags', 'roomChat', 'roomImages'])->find($id);
        if (isset($items)) {
            return view('wit.room', ['room_info' => $items, 'show_id' => $id]);
        } else {
            return view('wit.room2', ['room_info' => $items, 'show_id' => $id]);
        }
    }


    public function userGet()
    {
        $items = RoomUser::with('User')->get();
        return view('wit.ShowDatabase.showRoomUser', ['room_users' => $items]);
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
            //画像を保存して、そのパスを$imgに保存　第三引数に'public'を指定
            $img = $image_file->storeAs('roomImages', 'id' . $room_id . '_' . 'no' . $image_count . '.' . $extension,['disk'=>'local']);
            return $img;
        } else {
            return view('wit.home');
        }
    }


    public function create(Request $request)
    {
        //$this->validate($request, Room::$rules);
        //$this->validate($request, Tag::$rules);
        $image_count = 1;
        $room = new Room;
        $tag = new Tag;
        $room_tag = new RoomTag;
        $room_chat = new RoomChat;

        //roomsテーブルへ保存
        $room->user_id =  Auth::user()->id;
        $room->title = $request->title;
        $room->description = $request->description;
        if ($request->has('password')) {
            $room->password = $request->password;
        };
        $room->save();

        //room_chatテーブルへ保存
        $room_chat->room_id = $room->id;
        $room_chat->user_id = $room->user_id;
        $room_chat->message = $room->description;
        $room_chat->save();

        //room_imagesテーブルへ保存

        $room_image = new RoomImage;
        $room_image->room_id = $room->id;
        $room_image->image = $this->storeImage($request->file("roomImages"), $image_count, $room->id);
        $room_image->save();

        //tagの処理は今は適当
        $tag->name = $request->tag;
        $tag->number = 1;
        $tag->save();

        $room_tag->room_id = $room->id;
        $room_tag->tag_id = $tag->id;
        $room_tag->save();

        return redirect(route('getRoom', [
            'id' => $room->id,
        ]));
    }
}
