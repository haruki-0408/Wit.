<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $items = User::all();
        return view('wit.showUser' ,['users' => $items]);
    }
}
