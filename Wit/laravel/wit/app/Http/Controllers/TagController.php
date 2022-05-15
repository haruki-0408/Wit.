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
        return view('wit.ShowDatabase.showTag' ,['tags' => $items]);
    }

    public function relationGet(Request $requeset)
    {
        $items =RoomTag::with('Tag')->get();
        return view('wit.ShowDatabase.showRoomTag' ,['room_tags' =>$items]);
    }

    public static function getTrend()
    {
        $trend_tags = Tag::orderBy('number','desc')->take(15)->get(['name','number']);
        return $trend_tags; 
    }
}

