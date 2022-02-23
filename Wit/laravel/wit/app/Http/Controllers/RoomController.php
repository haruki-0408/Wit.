<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomUser;
use App\Models\RoomImage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $items = Room::all();
        return view('wit.showRoom',['rooms' => $items]);
    }

    public function userGet()
    {
        $items = RoomUser::with('User')->get();
        return view('wit.showRoomUser', ['room_users' =>$items]);
    }

    public function imageGet()
    {
        $items = RoomImage::with('Room')->get();
        return view('wit.showRoomImage', ['room_images' =>$items]);
    }
}

