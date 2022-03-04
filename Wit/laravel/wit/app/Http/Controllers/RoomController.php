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
            $img = $image_file->storeAs('roomImages/RoomID:' . $room_id, 'id' . $room_id . '_' . 'no' . $image_count . '.' . $extension, ['disk' => 'local']);
            return $img;
        }
    }

    public function storeTag($match)
    {
        //$tag = Tag::UpdateOrCreate(['name' => $tag_name], ['name' => $tag_name, 'number' => 1]);
        //入力されたタグのidを取得
        $tag = new Tag;
        $tag->name = $match;
        $tag->number = rand(1, 10);
        $tag->save();
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
        if ($request->has('password')) {
            $room->password = $request->password;
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

        //tagの処理は別関数にまかせて帰ってきた複数のtag_idをroom_idと紐付ける処理をしている
        if ($request->has('tag')) {
            preg_match_all('/([a-zA-Z0-9ぁ-んァ-ヶー-龠]+);/u', $request->tag, $matches);
            foreach ($matches[1] as $match) {
                $tag = $this->storeTag($match);
                $room_tag = new RoomTag;
                $room_tag->room_id = $room->id;
                $room_tag->tag_id = $tag->id;
                $room_tag->save();
            }
        }
        return redirect(route('getRoom', [
            'id' => $room->id, 
        ]));
    }
}
