<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ListUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\RoomController;


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
        if (Crypt::decrypt($user_id) == true) {
            //this payload is invalid 問題解決してない
            $decrypted_user_id = Crypt::decrypt($user_id);
            if (User::find($decrypted_user_id)->exists()) {
                $user = User::find($decrypted_user_id);
                $type = User::buttonTypeJudge($user->id);
                $user_data = [
                    'user_id' => $decrypted_user_id,
                    'type' => $type,
                    'profile_message' => $user->profile_message,
                    'user_name' => $user->name,
                    'profile_image' => $user->profile_image,
                    'post_rooms' => RoomController::getPostRoom($decrypted_user_id),
                ];

                return view('wit.profile', $user_data);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
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
                return back()->with('error_message', 'パスワードが違います');
            }
        }
    }

    /* 応答が遅いのでやめた
    public function showProfileImage($user_id)
    {
        $decrypted_user_id = Crypt::decrypt($user_id);
        $user = User::find($decrypted_user_id);
        $user_image_path = $user->profile_image;
        if($user_image_path == 'default' && Storage::exists('userImages/default/wit.png')){
            return response()->file(Storage::path('userImages/default/wit.png'));
        }else if(!Storage::exists($user_image_path)){
            abort(404);
        }

        return response()->file(Storage::path($user_image_path));
    }
    */


    public function storeImage($image_file)
    {
        if (isset($image_file)) {
            $user_id = Auth::id();
            $crypted_user_id = Crypt::encrypt($user_id);
            //拡張子を取得
            $extension = $image_file->getClientOriginalExtension();
            //画像を保存して、そのパスを$imgに保存　第三引数に'local'を指定
            Storage::disk('local')->deleteDirectory('/userImages/secondary:' . $user_id);
            //一旦中身を全削除してから新しい画像を登録
            $img = $image_file->storeAs('/userImages/secondary:' . $user_id, 'profile_image' . '.' . $extension, ['disk' => 'local']);

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
            //$crypt_img = Crypt::encrypt($img);
            $form += array('profile_image' => $img);
        };


        $user_id = Auth::id();
        $user = User::find($user_id);
        $user->fill($form)->save();
        $encrypted_user_id = Crypt::encrypt($user_id);
        return redirect(route("showProfile", ['user_id' => $encrypted_user_id]));
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
                    $encrypted_user_id = Crypt::encrypt($user_id);
                    return redirect(route("showProfile", ['user_id' => $encrypted_user_id]));
                } else {
                    return back()->with('error_message', '新しいパスワードと確認用のパスワードが一致していません');
                }
            } else {
                return back()->with('error_message', 'パスワードが違います');
            }
        }
    }

    protected function deleteAccount()
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $user->delete();
        Storage::disk('local')->deleteDirectory('/userImages/secondary:' . $user_id);
        return redirect(route('index'));
    }

    protected function searchUser(Request $request)
    {
        if (isset($request->keyword)) {
            $user_name = $request->keyword;
            if (isset($request->user_id)) {
                if($request->user_id == 'undefined'){
                    abort(404);
                }
                $user_id = Crypt::decrypt($request->user_id);
                $users = User::searchUserName($user_name)->orderby('id', 'asc')->where('id' ,'>', $user_id)->take(30)->get();
            } else {
                $users = User::searchUserName($user_name)->orderby('id', 'asc')->take(30)->get();
            }

            $search_query = User::searchUsername($user_name);

            $users->map(function ($each) use ($search_query) {
                $type = User::buttonTypeJudge($each->id, $search_query);
                $each['type'] = $type['type'];

                if ($type['no_get_more']) {
                    $each['no_get_more'] = $type['no_get_more'];
                }
                return $each;
            });

            foreach ($users as $user) {
                $user->id = Crypt::encrypt($user->id);
            }

            return response()->Json($users);
        } else {
            abort(404);
        }
    }

    public function actionListUser(Request $request)
    {
        if (isset($request->user_id)) {
            $message_type = ListUser::addListUser($request->user_id);
            switch ($message_type) {
                case 0:
                    $error_message = 'そのユーザは存在しません';
                    break;
                case 1:
                    $message = 'リストにユーザーを追加しました';
                    break;
                case 10:
                    $error_message = 'そのユーザは既にリストに登録されています';
                    break;
            }
        }

        if (isset($message)) {
            return response()->Json(["message" => $message]);
        } else {
            return response()->Json(["error_message" => $error_message]);
        }
    }

    public static function getListUser($user = null, $favorite_user_id = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $list_query = $user->listUsers();
        $list_users = $user->listUsers()->take(30)->get();

        $list_users->map(function ($each) use ($list_query) {
            $type = User::buttonTypeJudge($each->id, null, $list_query);
            $each['type'] = $type['type'];

            if ($type['no_get_more']) {
                $each['no_get_more'] = $type['no_get_more'];
            }
            return $each;
        });

        return $list_users;
    }
}
