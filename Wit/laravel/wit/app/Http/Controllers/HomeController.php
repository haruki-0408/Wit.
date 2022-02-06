<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('wit.home');
    }

    public function showProfile()
    {
        return view('wit.profile');
    }

    public function enterRoom($room_id)
    {
        $id = ["id"=>$room_id];
        return view('wit.room',$id);
    }
}
