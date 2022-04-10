<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


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

    public function showProfile($user_id)
    {
        $user = User::find($user_id);
        $user_data = [
        'user_id'=>$user_id,
        'profile_image' => $user->profile_image,
        'profile_message' => $user->profile_message,
        'user_name' => $user->name,
        ];
        return view('wit.profile', $user_data);
    }

    public function settings($query)
    {
        switch ($query) { //query string によってどのページに飛ばすのか判定
            case 'info':
                return view('wit.Account.information-account');

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

    public function storeImage($image_file)
    {
        if (isset($image_file)) {
            $user_id = Auth::id();
            //拡張子を取得
            $extension = $image_file->getClientOriginalExtension();
            //画像を保存して、そのパスを$imgに保存　第三引数に'local'を指定
            Storage::disk('local')->deleteDirectory('/userImages/UserID:' . $user_id);
            //一旦中身を全削除してから新しい画像を登録
            $img = $image_file->storeAs('/userImages/UserID:' . $user_id, 'id' . $user_id . '.' . $extension, ['disk' => 'local']);
            //id=1なら'id1.png'とかになる
            return $img;
        }
    }

    protected function changeProfile(Request $request)
    {
        $form = [
            'name' => $request->name,
            'email' => $request->email,
            'profile_message' => $request->message,

        ];

        if (isset($request->edit_image)) {
            $img = $this->storeImage($request->edit_image);
            $form += array('profile_image' => $img);
        };


        $user_id = Auth::id();
        $user = User::find($user_id);
        $user->fill($form)->save();
        return redirect(route("showProfile"));
    }

    protected function changePassword(Request $request)
    {
        if (isset($request->currentPass) && isset($request->newPass) && isset($request->confirmPass)) {
            $user_id = Auth::id();
            $user = User::find($user_id);
            $password = $user->password;
            $current_password = $request->currentPass;
            $new_password = $request->newPass;
            $confirm_password = $request->confirmPass;
            if (Hash::check($current_password, $password)) {
                if ($new_password == $confirm_password) {
                    $user->password = Hash::make($new_password);
                    $user->save();
                    return redirect(route("showProfile"));
                } else {
                    return back()->with('flashmessage', '新しいパスワードと確認用のパスワードが一致していません');
                }
            } else {
                return back()->with('flashmessage', 'パスワードが違います');
            }
        }
    }

    protected function deleteAccount()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $user->delete();
        return redirect(route('index'));
    }
}
