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
        return view('wit.ShowDatabase.showUser' ,['users' => $items]);
    }

    public function showProfile()
    {
        return view('wit.profile');
    }

    public function settings()
    {
        $ref = 'info';
        switch ($ref) {
            case 'info':
                return view('wit.account-information');
            case 'change':
                return view('wit.change-password');
            case 'delete':
                return view('wit.delete-account');
        }
    }

    protected function authUserPassword(Request $request)
    {
        $user = Auth::user();
        $password = $user->password;
        $setting_password = $request->settingPass;
        if (Hash::check($setting_password, $password)) {
            return redirect(route('settings'));
        } else {
            return back()->with('flashmessage', 'パスワードが違います');
        }
    }
    
}
