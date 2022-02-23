<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Tag;
use App\Models\RoomUser;
use App\Models\RoomImage;
use App\Models\RoomChat;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $items = Room::all();
        return view('wit.ShowDatabase.showRoom',['rooms' => $items]);
    }

    public function getRoomInfo($id)
    {
        $items = Room::with(['roomTags', 'roomChat' ,'roomImages'])->where('id',$id)->get();

        return view('wit.roomtest' ,['room_informations' => $items,'show_id'=>$id]);
    }


    public function userGet()
    {
        $items = RoomUser::with('User')->get();
        return view('wit.ShowDatabase.showRoomUser', ['room_users' =>$items]);
    }

    public function imageGet()
    {
        $items = RoomImage::with('Room')->get();
        return view('wit.ShowDatabase.showRoomImage', ['room_images' =>$items]);
    }

    public function chatGet()
    {
        $items = RoomChat::with('User')->with('Room')->get();
        return view('wit.ShowDatabase.showRoomChat',['room_chat' =>$items]);
    }

    public function storeImage($imageFile)
    {
        $image = new RoomImage;
        // name属性が'thumbnail'のinputタグをファイル形式に、画像をpublic/imagesに保存
        $image_path = $imageFile->store('public/images/');

        // 上記処理にて保存した画像のPATHをRoomImageテーブルのimageカラムに、格納
        $image->image = basename($image_path); //basenameメソッドでファイルのパスを保存

        return $image;
    }

    public function create(Request $request)
    {
        $this->validate($request, Room::$rules);
        $this->validate($request, Tag::$rules);

        $room = new Room;
        $room_image = new RoomImage;
        $tag = new Tag;
        $room_tag = new RoomTag;
        $room_chat = new RoomChat;

        //roomsテーブルへ保存
        $room->user_id =  Auth::user()->id;
        $room->title = $request->title;
        $room->description = $request->description;
        if($request->has('password')){
            $room->password = $request->password;
        };
        $room->save();

        //room_chatテーブルへ保存
        $room_chat->room_id = $room->id;
        $room_chat->user_id = $room->user_id;
        $room_chat->message = $room->description;
        $room_chat->save();
        
        //room_imagesテーブルへ保存
        $room_image->room_id =$room->id;
        $room_image->storeImage($request->file("roomImage"));
        $room_image->save();


        //tagの処理は今は適当
        $tag ->name = $request->tag;
        $tag ->number = 1;
        $tag->save();

        $room_tag->room_id = $room->id;
        $room_tag->tag_id = $tag->id;
        $room_tag->save();
        
        return redirect()->route('/home/room/{id?}')->with('id', $room->id);
        
    }
}


