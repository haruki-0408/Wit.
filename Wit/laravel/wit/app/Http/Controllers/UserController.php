<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $items = User::all();
        return view('wit.ShowDatabase.showUser' ,['users' => $items]);
    }
}
