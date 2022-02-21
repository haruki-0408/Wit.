<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\RoomTag;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $items = Tag::all();
        return view('wit.showTag', ['tags' => $items]);
    }

    public function relationGet(Request $requeset)
    {
        $items =RoomTag::with('tag')->get();
        return view('wit.showRoomTag', ['room_tags' =>$items]);
    }
}
