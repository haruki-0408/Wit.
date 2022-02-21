<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $items = Room::all();
        return view('wit.showRoom',['rooms' => $items]);
    }
}

