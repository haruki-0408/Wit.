<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items = User::all();
        return view('wit.ShowDatabase.showUser', ['users' => $items]);
    }

    public function showProfile()
    {
        return view('wit.profile');
    }

    public function settings($query)
    {
        switch ($query) { //query string によってどのページに飛ばすのか判定
            case 'info':
                return view('wit.Account.information-account');
            case 'change':
                return view('wit.Account.change-password');
            case 'delete':
                return view('wit.Account.delete-account');
        }
    }

    protected function authUserPassword(Request $request)
    {
        $query = $request->query('ref');
        if (isset($query)) {
            $user = Auth::user();
            $password = $user->password;
            $setting_password = $request->settingPass;
            if (Hash::check($setting_password, $password)) {
                return $this->settings($query);
            } else {
                return back()->with('flashmessage', 'パスワードが違います');
            }
        }
    }
}
