<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Mail\Inquiry;
use Illuminate\Support\Facades\Mail;
use App\Events\RemoveRoom;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\RoomController;
use App\Http\Requests\ChangeProfileRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\AuthPasswordRequest;
use App\Mail\ChangeEmail;
use Laravel\Ui\Presets\React;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function showProfile($user_id)
    {
        if (is_null($user_id)) {
            abort(404);
        }
        $decrypted_user_id = Crypt::decrypt($user_id);

        if (User::where('id', $decrypted_user_id)->doesntExist()) {
            abort(404);
        }

        $user = User::find($decrypted_user_id);
        $type = User::buttonTypeJudge($user->id);
        $user_data = [
            'user_id' => $decrypted_user_id,
            'type' => $type['type'],
            'profile_message' => $user->profile_message,
            'user_name' => $user->name,
            'profile_image' => $user->profile_image,
        ];

        if ($user != Auth::user()) {
            $user_data += array('o_open_rooms' => RoomController::getOpenRoom($user_id));
            $user_data += array('o_post_rooms' => RoomController::getPostRoom(null, $user_id));
            $user_data += array('o_list_users' => Self::getListUser(null, $user_id));
            $user_data += array('o_list_rooms' => RoomController::getListRoom(null, $user_id));
        }

        return view('wit.profile', $user_data);
    }

    public function settings(Request $request)
    {
        if (session()->get('auth_user_id') == Auth::id()) {
            session()->forget('auth_user_id');
            switch ($request->input('ref')) { //query string によってどのページに飛ばすのか判定
                case 'info':
                    return view('wit.Account.information-account');

                case 'email':
                    return view('wit.Account.change-email');

                case 'delete':
                    return view('wit.Account.delete-account');
                default:
                    return redirect('home')->with('error_message', 'エラーが起きました');
            }
        } else {
            abort(404);
        }
    }

    protected function authUserPassword(AuthPasswordRequest $request)
    {
        $query = $request->input('ref');

        if (is_null($query)) {
            return back()->with('error_message', 'エラーが起きました');
        }

        $user = Auth::user();
        $password = $user->password;

        if ($request->has('information_password')) {
            $setting_password = $request->information_password;
        } else if ($request->has('delete_password')) {
            $setting_password = $request->delete_password;
        } else if ($request->has('change_email_password')) {
            $setting_password = $request->change_email_password;
        }

        if (Hash::check($setting_password, $password)) {
            session()->put(['auth_user_id' => Auth::id()]);
            return $this->settings($request);
        } else {
            return back()->with('error_message', 'パスワードが違います');
        }
    }


    public function storeImage($image_file)
    {
        if (isset($image_file)) {
            $user_id = Auth::id();
            //拡張子を取得
            $extension = $image_file->getClientOriginalExtension();
            //画像を保存して、そのパスを$imgに保存　第三引数に'local'を指定
            Storage::disk('local')->deleteDirectory('/userImages/secondary:' . $user_id);
            //一旦中身を全削除してから新しい画像を登録
            $img = $image_file->storeAs('/userImages/secondary:' . $user_id, 'profile_image' . '.' . $extension, ['disk' => 'local']);
            //$img の中身は/から始まっていない
            return $img;
        }
    }

    protected function changeProfile(ChangeProfileRequest $request)
    {
        $form = [
            'name' => $request->name,
            'profile_message' => $request->message,
        ];

        if (isset($request->image)) {
            $img = $this->storeImage($request->image);
            //$crypt_img = Crypt::encrypt($img);
            $form += array('profile_image' => $img);
        };


        $user_id = Auth::id();
        $user = User::find($user_id);
        $user->fill($form)->save();
        $encrypted_user_id = Crypt::encrypt($user_id);
        return redirect(route("showProfile", ['user_id' => $encrypted_user_id]));
    }

    protected function changeEmail(ChangeEmailRequest $request)
    {
        if (User::where('email', $request->input('email'))->exists()) {
            return redirect('/home')->with('error_message', 'そのメールアドレスはすでに登録されています');
        } else {
            $email_address = $request->input('email');
            $user_id = Auth::id();
            $user = User::find($user_id);
            //email_verified_tokenを変更
            $user->email_verified_token = base64_encode($email_address);
            $user->save();
        }

        $email = new ChangeEmail($user);
        Mail::to($email_address)->send($email);

        return view('wit.Account.send-change-email');
    }

    protected function changePassword(ChangePasswordRequest $request)
    {
        if (is_null($request->current_password) || is_null($request->new_password) || is_null($request->new_password_confirmation)) {
            return back()->with('error_message', 'エラーが起きました');
        }

        $user_id = Auth::id();
        $user = User::find($user_id);
        $password = $user->password;
        $current_password = $request->current_password;
        $new_password = $request->new_password;
        $confirm_password = $request->new_password_confirmation;

        if (!(Hash::check($current_password, $password))) {
            return back()->with('error_message', 'パスワードが違います');
        }

        if ($new_password !== $confirm_password) {
            return back()->with('error_message', '新しいパスワードと確認用のパスワードが一致していません');
        }

        $user->password = Hash::make($new_password);
        $user->save();
        $encrypted_user_id = Crypt::encrypt($user_id);
        return redirect(route("showProfile", ['user_id' => $encrypted_user_id]))->with('action_message', 'パスワードを変更しました');
    }

    protected function deleteAccount(Request $request)
    {
        if ($request->auth !== 'auth') {
            abort(404);
        }
        $user_id = Auth::id();
        $user = User::find($user_id);
        $rooms = $user->rooms()->get();

        foreach ($rooms as $room) {
            $room_tags = $room->tags()->get();

            foreach ($room_tags as $room_tag) {
                if (Tag::where('id', $room_tag->pivot->tag_id)->doesntExist()) {
                    return redirect('home')->with('error_message', 'tag エラー');
                }

                $tag = Tag::find($room_tag->pivot->tag_id);
                if ($tag->number < 1) {
                    $tag->delete();
                } else {
                    $tag->update([
                        'number' => $tag->number - 1
                    ]);
                }
            }

            $room->delete();
            event(new RemoveRoom($room->id));
            Storage::disk('local')->deleteDirectory('/roomImages/RoomID:' . $room->id);
        }
        $user->delete();
        Storage::disk('local')->deleteDirectory('/userImages/secondary:' . $user_id);
        return redirect(route('index'));
    }
    public function getInquiryForm($inquiry_sentence = null)
    {
        $user = Auth::user();
        $email = $user->email;
        if (isset($inquiry_sentence)) {
            return view('wit.Account.inquiry-form', ['inquiry_sentence' => $inquiry_sentence, 'email' => $email]);
        } else {
            return view('wit.Account.inquiry-form');
        }
    }

    public function receiveInquiry(Request $request)
    {
        $rules = [
            'inquiry_sentence' => 'required|string|max:1000',
        ];

        $messages = [
            'inquiry_sentence.required' => '内容を入力してください',
            'inquiry_sentence.max' => '最大文字数(1000文字)を超過しました',
        ];
        $request->validate($rules, $messages);

        $inquiry_sentence = $request->inquiry_sentence;
        return $this->getInquiryForm($inquiry_sentence);
    }

    public function sendInquiry(Request $request)
    {
        if (isset($request->inquiry_sentence)) {
            $user = Auth::user();
            // $inquiry_sentence = $request->inquiry_sentence;
            // $email = new Inquiry($user, $inquiry_sentence);
            // Mail::to('wit-info@wit-dot.com')->send($email);
            // return redirect('/home')->with('action_message', 'お問い合わせ内容が送信されました');
            return redirect('/home')->with('error_message', 'お問い合わせ機能は停止中です');
        }

        return redirect('/home')->with('error_message', 'お問い合わせがエラーにより送信できませんでした');
    }

    protected function searchUser(Request $request)
    {
        if (is_null($request->keyword)) {
            abort(404);
        }

        $user_name = $request->keyword;

        if ($request->user_id == 'undefined') {
            abort(404);
        }

        if (isset($request->user_id)) {
            $user_id = Crypt::decrypt($request->user_id);
            $users = User::searchUserName($user_name)->where('id', '>', $user_id)->take(30)->get();
            $search_query = User::searchUserName($user_name);
        } else {
            $users = User::searchUserName($user_name)->take(30)->get();
            $search_query = User::searchUserName($user_name);
        }

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
    }
    public static function getListUser($favorite_user_id = null, $user_id = null)
    {
        if (isset($user_id)) {
            $decrypted_user_id = Crypt::decrypt($user_id);
            $user = User::find($decrypted_user_id);
        } else {
            $user_id = Auth::id();
            $user = User::find($user_id);
        }

        $list_query = $user->listUsers();


        if (isset($favorite_user_id)) {
            $favorite_user_id = Crypt::decrypt($favorite_user_id);
            $list_user_id = $user->listUsers()->where('favorite_user_id', $favorite_user_id)->value('list_users.id');
            $list_users = $user->listUsers()->where('list_users.id', '<', $list_user_id)->orderBy('list_users.id', 'desc')->take(30)->get();
        } else {
            $list_users = $user->listUsers()->orderBy('list_users.id', 'desc')->take(30)->get();
        }

        $list_users->map(function ($each) use ($list_query) {
            $type = User::buttonTypeJudge($each->id, null, $list_query);
            $each['type'] = $type['type'];

            if ($type['no_get_more']) {
                $each['no_get_more'] = $type['no_get_more'];
            }
            return $each;
        });

        foreach ($list_users as $list_user) {
            $list_user->id = Crypt::encrypt($list_user->id);
        }


        return $list_users;
    }

    public function actionAddListUser($user_id)
    {
        if (isset($user_id)) {
            $message_type = User::addListUser($user_id);
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

    public function actionRemoveListUser($user_id)
    {
        if (isset($user_id)) {
            $message_type = User::removeListUser($user_id);
            switch ($message_type) {
                case 0:
                    $error_message = 'そのユーザはリストに登録されていません';
                    break;
                case 1:
                    $message = 'リストからユーザーを削除しました';
                    break;
                default:
                    $error_message = 'そのユーザは存在しません';
                    break;
            }
        }

        if (isset($message)) {
            return response()->Json(["message" => $message]);
        } else {
            return response()->Json(["error_message" => $error_message]);
        }
    }
}
