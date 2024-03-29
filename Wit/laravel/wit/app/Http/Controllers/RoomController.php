<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\ChoiceMessagesRequest;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\AuthPasswordRequest;
use App\Events\UserEntered;
use App\Events\UserExited;
use App\Events\SendMessage;
use App\Events\UploadFile;
use App\Events\ChoiceMessages;
use App\Events\RemoveRoom;
use App\Events\SaveRoom;
use App\Events\RoomBanned;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomChat;
use App\Models\RoomUser;
use App\Models\Tag;
use App\Models\RoomImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    public function searchRoom(Request $request)
    {
        $query = Room::query();
        //queryを２つ用意しないとオーバーライドされてしまう
        $second_query = Room::query();


        switch ($request->search_type) {
            case 'keyword':
                if (isset($request->keyword)) {
                    $query->searchRoomName($request->keyword);
                    $second_query->searchRoomName($request->keyword);
                }
                break;

            case 'id':
                if (isset($request->keyword)) {
                    $query->searchRoomId($request->keyword);
                    $second_query->searchRoomId($request->keyword);
                } else {
                    $array = [];
                    return $array;
                }
                break;
            case 'tag':
                if (isset($request->keyword)) {
                    $query->searchTagName($request->keyword);
                    $second_query->searchTagName($request->keyword);
                } else {
                    $array = [];
                    return $array;
                }
                break;
        }


        if ($request->search_type !== 'id') {
            if ($request->check_image != 'false') {
                $query->doesntHave('roomImages');
                $second_query->doesntHave('roomImages');
            }

            if ($request->check_tag != 'false' && $request->search_type != 'tag' && $request->check_post == 'false') {
                $query->doesntHave('tags');
                $second_query->doesntHave('tags');
            }

            if ($request->check_password != 'false' && $request->check_post == 'false') {
                $query->searchRoomPassword();
                $second_query->searchRoomPassword();
            }

            if ($request->check_post != 'false') {
                $query->searchPostRoom();
                $second_query->searchPostRoom();
            }
        }

        if (is_null($request->room_id)) {
            $rooms = $query->orderBy('id', 'desc')->with(['user', 'tags'])->take(15)->get();
        } else if (Room::find($request->room_id)->exists()) {
            $room_id = $request->room_id;
            $rooms = $query->where('id', '<', $room_id)->orderBy('id', 'desc')->with(['user', 'tags'])->take(10)->get();
        } else {
            abort(404);
        }

        $rooms->map(function ($each) use ($second_query) {
            $count_online_users = RoomUser::countOnlineUsers($each->id);
            $count_chat_messages = $each->roomChat()->count();
            $expired_time_left = Room::getRoomExpiredTime($each->id);
            $type = Room::buttonTypeJudge($each->id, $second_query);
            $each['type'] = $type['type'];
            $each['count_online_users'] = $count_online_users;
            $each['count_chat_messages'] = $count_chat_messages;
            $each['expired_time_left'] = $expired_time_left;

            if ($type['no_get_more']) {
                $each['no_get_more'] = $type['no_get_more'];
            }
            return $each;
        });

        foreach ($rooms as $room) {
            $room->user->id = Crypt::encrypt($room->user->id);
            $room->user_id = Crypt::encrypt($room->user_id);
        }
        //return $rooms;
        return response()->Json($rooms);
    }


    public static function getRoomInfo($room_id = null) //引数省略可能なメソッドにしてページ読み込み時と追加読み込み時に分けている
    {
        if (is_null($room_id)) {
            $rooms = Room::with(['user', 'tags'])->whereNull('posted_at')->take(15)->get();
        } else {
            if (Room::find($room_id)->exists()) {
                $rooms = Room::where('id', '<', $room_id)->orderBy('id', 'DESC')->with(['user', 'tags'])->whereNull('posted_at')->take(10)->get();
            } else {
                abort(404);
            }
        }

        $rooms->map(function ($each) {
            $count_online_users = RoomUser::countOnlineUsers($each->id);
            $count_chat_messages = $each->roomChat()->count();
            $expired_time_left = Room::getRoomExpiredTime($each->id);
            $type = Room::buttonTypeJudge($each->id);
            $each['type'] = $type['type'];
            $each['count_online_users'] = $count_online_users;
            $each['count_chat_messages'] = $count_chat_messages;
            $each['expired_time_left'] = $expired_time_left;

            if ($type['no_get_more']) {
                $each['no_get_more'] = $type['no_get_more'];
            }
            return $each;
        });

        foreach ($rooms as $room) {
            $room->user->id = Crypt::encrypt($room->user->id);
            $room->user_id = Crypt::encrypt($room->user_id);
        }

        return $rooms;
    }

    public function authRoomPassword(AuthPasswordRequest $request)
    {
        if (is_null($request->room_id)) {
            return redirect('home')->with('error_message', 'エラーが発生しました');
        }

        $room_id = $request->room_id;
        $room = Room::find($room_id);
        $room_password = $room->password;

        if (is_null($request->enter_password) || is_null($room_password)) {
            return redirect('home')->with('error_message', 'エラーが発生しました');
        }

        //バリデーションですでにパスワードのチェックは完了しているのでこのエラーが発生することは理論上はない
        if (!(Hash::check($request->enter_password, $room_password))) {
            return redirect('/home')->with('error_message', 'パスワードが違います');
        }
        session()->put('auth_room_id', $room_id);

        return redirect(route('enterRoom', [
            'room_id' => $room->id,
        ]));
    }

    public function enterRoom($room_id)
    {
        if (Room::where('id', $room_id)->doesntExist()) {
            return redirect('home')->with('error_message', 'ルーム:' . $room_id . 'は存在しません');
        }

        if (Room::find($room_id)->posted_at != null) {
            return redirect(route('showPostRoom', [
                'room_id' => $room_id,
            ]));
        }

        $auth_user = Auth::user();
        $check = Room::checkRoomAccess(Auth::id(), $room_id);
        $count_online_others = RoomUser::countOnlineOthers($room_id);

        if ($check) {
            return redirect('home')->with('error_message', 'ルーム:' . $room_id . 'へのアクセスが禁止されています');
        }

        if ($count_online_others >= 10 && $auth_user->id !== Room::find($room_id)->user_id) {
            return redirect('home')->with('error_message', 'ルームの最大人数(作成者を除いて10人まで)を超過したため入室できません');
        }

        $room_info = Room::with(['user:id,name,profile_image', 'tags:name,number'])->find($room_id);


        $count_image_data = RoomImage::where('room_id', $room_id)->get('image')->count();

        if (isset($room_info->password) && session()->get('auth_room_id') != $room_id) {
            return redirect('home')->with('error_message', 'パスワード付きのルームです');
        }

        event(new UserEntered($room_id));

        return view('wit.room', [
            'room_info' => $room_info,
            'count_image_data' => $count_image_data,
            'auth_user' => $auth_user,
            'expired_time_left' => Room::getRoomExpiredTime($room_id),
        ]);
    }

    public function showPostRoom($room_id)
    {
        if (Room::where('id', $room_id)->doesntExist()) {
            return redirect('home')->with('error_message', 'ルーム:' . $room_id . 'は存在しません');
        }

        if (is_null(Room::find($room_id)->posted_at)) {
            return redirect(route('enterRoom', [
                'room_id' => $room_id,
            ]));
        }

        $auth_user = Auth::user();
        $room_info = Room::with(['user:id,name,profile_image', 'tags:name,number'])->find($room_id);
        $count_image_data = RoomImage::where('room_id', $room_id)->get('image')->count();

        return view('wit.post_room', [
            'room_info' => $room_info,
            'count_image_data' => $count_image_data,
            'auth_user' => $auth_user,
        ]);
    }

    public function saveRoom(Request $request)
    {
        if (is_null($request->room_id)) {
            return redirect('home')->with('error_message', 'エラーが発生しました');
        }
        $room_id = $request->room_id;

        if (Room::where('id', $room_id)->doesntExist()) {
            return redirect('home')->with('error_message', 'ルーム:' . $room_id . 'は存在しません');
        }
        $room = Room::find($room_id);

        if ($room->user_id !== Auth::id()) {
            return redirect('home')->with('error_message', 'ログインユーザーとルームの作成者が一致しません');
        }

        if ($room->password !== null) {
            return redirect('home')->with('error_message', 'ルームにパスワードがついているため保存できません');
        }

        if ($room->tags->count() == 0) {
            return redirect('home')->with('error_message', 'ルームにタグが付いていないため保存できません');
        }

        $room->roomBans()->detach();

        $room->posted_at = Carbon::now();
        $room->save();
        event(new SaveRoom($room_id));
        return redirect('home')->with('action_message', 'ルーム:' . $room_id . 'の保存が完了しました');
    }

    public function receiveWebhooks(Request $request)
    {
        //唯一の外部Api処理
        if (is_null($request->headers->get('X-Pusher-Signature'))) {
            abort(404);
        }
        Log::info($request->headers);
        Log::info($request->all());
        //pusherからのRequestなのかどうかをチェックしなくてはならない
        //チェックがない状態だと誰でもWebhookを送信してこられるのでまずい
        $webhook_signature = $request->headers->get('X-Pusher-Signature');
        $body = file_get_contents('php://input');
        $app_secret = env('PUSHER_APP_SECRET');
        //requestのbodyの中身をpusherの秘密鍵と合わせてsha256でハッシュ化したものを電子署名として送信してきている
        $expected_signature = hash_hmac('sha256', $body, $app_secret, false);

        //電子署名が有効化かどうかを確認
        if ($expected_signature == $webhook_signature) {
            foreach ($request->events as $event) {
                if ($event['name'] == 'member_removed') {
                    $room_id = substr($event['channel'], -26);
                    $user_id = $event['user_id'];
                    event(new UserExited($room_id, $user_id));
                    return response()->Json('User Exited');
                } else if ($event['name'] == 'member_added') {
                    return response()->Json('User Entered');
                }
            }
        } else {
            abort(404);
        }
    }

    public function receiveMessage(Request $request)
    {
        $room = new Room;
        $chat_count = $room->find($request->room_id)->roomChat->count();
        $request->merge(['chat_count' => $chat_count]);

        $rules = [
            'message' => 'required|max:1000',
            'chat_count' => 'integer|max:999',
        ];

        $message = [
            'message.required' => 'メッセージを入力して下さい',
            'message.max' => 'メッセージは最大1000文字までです',
            'chat_count.integer' => 'エラーにより送信できません',
            'chat_count.max' => 'ルームの最大メッセージ数(1000)に達しました',
        ];
        $request->validate($rules, $message);

        $user = User::find($request->user()->id);
        $user->roomChat()->attach($request->room_id, ['message' => $request->message]);
        $chat_id = $user->roomChat->sortBy('id')->last()->pivot->id;

        event(new SendMessage($request->room_id, $request->user(), $chat_id, $request->message));
        return response()->Json('Message Broadcast');
    }

    public function receiveFile(UploadFileRequest $request)
    {
        $file_name = $this->storeFile($request->file('file'), $request->room_id);

        $user = User::find($request->user()->id);
        $user->roomChat()->attach($request->room_id, ['postfile' => $file_name]);
        $chat_id = $user->roomChat->sortBy('id')->last()->pivot->id;
        event(new UploadFile($request->room_id, $request->user(), $chat_id, $file_name));
        return response()->Json('File Send Success');
    }

    public function receiveChoiceMessages(ChoiceMessagesRequest $request)
    {
        $room = Room::find($request->room_id);
        if($room->user_id !== $request->user()->id){
            abort(404);
        }
        
        $target_array = $request->target_array;
        foreach ($target_array as $target_id) {
            $room_chat = $room->roomChat()->where('room_chat.id', $target_id)->first();
            if ($room_chat->pivot->choice) {
                DB::table('room_chat')->where('id', $target_id)->update(['choice' => false]);
            } else {
                DB::table('room_chat')->where('id', $target_id)->update(['choice' => true]);
            }
        }
        event(new ChoiceMessages($request->room_id, $request->user()->id, $target_array));
        return response()->Json('Message Choiced');
    }

    public function receiveBanUser(Request $request)
    {

        if (!($request->filled(['user_id', 'room_id']))) {
            return redirect('home')->with('error_message', 'エラーが発生しました');
        }

        if (Room::where('id', $request->room_id)->doesntExist()) {
            return redirect('home')->with('error_message', 'エラーが発生しました');
        }

        if (User::where('id', $request->user_id)->doesntExist()) {
            return redirect(route('enterRoom', [
                'room_id' => $request->room_id,
            ]));
        }

        $user = User::find($request->user_id);
        $room = new Room;


        if ($request->user_id == Auth::id() || $room->find($request->room_id)->user_id !== Auth::id()) {
            return redirect(route('enterRoom', [
                'room_id' => $request->room_id,
            ]));
        }

        $room->find($request->room_id)->roomBans()->syncWithoutDetaching($request->user_id);
        $room->find($request->room_id)->roomUsers()->detach($request->user_id);
        $type = 'ban';
        event(new RoomBanned($user, $request->room_id, $type));
        return redirect(route('enterRoom', [
            'room_id' => $request->room_id,
        ]));
    }

    public function receiveLiftBanUser(Request $request)
    {
        if (!($request->filled(['user_id', 'room_id']))) {
            return redirect('home')->with('error_message', 'エラーが発生しました');
        }

        if (Room::where('id', $request->room_id)->doesntExist()) {
            return redirect('home')->with('error_message', 'エラーが発生しました');
        }

        if (User::where('id', $request->user_id)->doesntExist()) {
            return redirect(route('enterRoom', [
                'room_id' => $request->room_id,
            ]));
        }

        $user = User::find($request->user_id);
        $room = new Room;

        if ($request->user_id == Auth::id() || $room->find($request->room_id)->user_id !== Auth::id()) {
            return redirect(route('enterRoom', [
                'room_id' => $request->room_id,
            ]));
        }

        $room->find($request->room_id)->roomBans()->detach($request->user_id);
        $type = 'lift';
        event(new RoomBanned($user, $request->room_id, $type));
        return redirect(route('enterRoom', [
            'room_id' => $request->room_id,
        ]));
    }

    public static function getOpenRoom($user_id = null)
    {
        if (isset($user_id)) {
            $decrypted_user_id = Crypt::decrypt($user_id);
            $user = User::find($decrypted_user_id);
        } else {
            $user_id = Auth::id();
            $user = User::find($user_id);
        }

        $open_rooms = $user->rooms()->whereNull('posted_at')->orderBy('id', 'desc')->with(['user', 'tags'])->get();

        $open_rooms->map(function ($each) {
            $type = Room::buttonTypeJudge($each->id);
            $each['type'] = $type['type'];
            $count_online_users = RoomUser::countOnlineUsers($each->id);
            $count_chat_messages = $each->roomChat()->count();
            $expired_time_left = Room::getRoomExpiredTime($each->id);
            $each['count_online_users'] = $count_online_users;
            $each['count_chat_messages'] = $count_chat_messages;
            $each['expired_time_left'] = $expired_time_left;
            return $each;
        });

        foreach ($open_rooms as $open_room) {
            $open_room->user->id = Crypt::encrypt($open_room->user->id);
            $open_room->user_id = Crypt::encrypt($open_room->user_id);
        }

        return $open_rooms;
    }

    public static function getPostRoom($room_id = null, $user_id = null)
    {
        if (isset($user_id)) {
            $decrypted_user_id = Crypt::decrypt($user_id);
            $user = User::find($decrypted_user_id);
        } else {
            $user_id = Auth::id();
            $user = User::find($user_id);
        }

        $query = $user->rooms()->whereNotNull('posted_at');

        if (is_null($room_id)) {
            $post_rooms = $user->rooms()->orderBy('id', 'desc')->whereNotNull('posted_at')->with(['user', 'tags'])->take(10)->get();
        } else {
            $post_rooms = $user->rooms()->orderBy('id', 'desc')->where('id', '<', $room_id)->whereNotNull('posted_at')->with(['user', 'tags'])->take(10)->get();
        }

        $post_rooms->map(function ($each) use ($query) {
            $type = Room::buttonTypeJudge($each->id, $query);
            $each['type'] = $type['type'];

            if ($type['no_get_more']) {
                $each['no_get_more'] = $type['no_get_more'];
            }
            return $each;
        });

        foreach ($post_rooms as $post_room) {
            $post_room->user->id = Crypt::encrypt($post_room->user->id);
            $post_room->user_id = Crypt::encrypt($post_room->user_id);
        }

        return $post_rooms;
    }

    public static function getListRoom($room_id = null, $user_id = null)
    {
        if (isset($user_id)) {
            $decrypted_user_id = Crypt::decrypt($user_id);
            $user = User::find($decrypted_user_id);
        } else {
            $user_id = Auth::id();
            $user = User::find($user_id);
        }

        $list_query = $user->listRooms();
        if (is_null($room_id)) {
            $list_rooms = $user->listRooms()->orderBy('list_rooms.id', 'desc')->with(['user', 'tags'])->take(10)->get();
        } else if (isset($room_id)) {
            $list_rooms_id = $user->listRooms()->where('room_id', $room_id)->value('list_rooms.id');
            $list_rooms = $user->listRooms()->where('list_rooms.id', '<', $list_rooms_id)->orderBy('list_rooms.id', 'desc')->with(['user', 'tags'])->take(10)->get();
        }
        $list_rooms->map(function ($each) use ($list_query) {
            $count_online_users = RoomUser::countOnlineUsers($each->id);
            $count_chat_messages = $each->roomChat()->count();
            $expired_time_left = Room::getRoomExpiredTime($each->id);
            $type = Room::buttonTypeJudge($each->id, null, $list_query);
            $each['type'] = $type['type'];
            $each['count_online_users'] = $count_online_users;
            $each['count_chat_messages'] = $count_chat_messages;
            $each['expired_time_left'] = $expired_time_left;


            if ($type['no_get_more']) {
                $each['no_get_more'] = $type['no_get_more'];
            }
            return $each;
        });

        foreach ($list_rooms as $list_room) {
            $list_room->user->id = Crypt::encrypt($list_room->user->id);
            $list_room->user_id = Crypt::encrypt($list_room->user_id);
        }
        return $list_rooms;
    }

    public function actionAddListRoom($add_room_id)
    {
        if (Room::where('id', $add_room_id)->doesntExist()) {
            $error_message = 'ルーム:' . $add_room_id . 'は存在しません';
            return response()->Json(["error_message" => $error_message]);
        }

        $room_id = $add_room_id;

        $message_type = Room::addListRoom($room_id);
        switch ($message_type) {
            case 0:
                $error_message = 'このルームは既にリストに追加されています';
                break;
            case 1:
                $message = 'リストにルームを追加しました';
                break;
            default:
                $error_message = 'エラーが発生しました';
                break;
        }

        if (isset($message)) {
            return response()->Json(["message" => $message]);
        } else {
            return response()->Json(["error_message" => $error_message]);
        }
    }

    public function actionRemoveListRoom($remove_room_id)
    {
        if (Room::where('id', $remove_room_id)->doesntExist()) {
            $error_message = 'ルーム:' . $remove_room_id . 'は存在しません';
            return response()->Json(["error_message" => $error_message]);
        }

        $room_id = $remove_room_id;

        $message_type = Room::removeListRoom($room_id);
        switch ($message_type) {
            case 0:
                $error_message = 'このルームはリストに登録されていません';
                break;
            case 1:
                $message = 'リストからルームを削除しました';
                break;
            default:
                $error_message = 'エラーが発生しました';
                break;
        }

        if (isset($message)) {
            return response()->Json(["message" => $message]);
        } else {
            return response()->Json(["error_message" => $error_message]);
        }
    }

    //ルーム画像だけは別のメソッドで返す。　不正アクセス対策
    public function showRoomImage($room_id, $number)
    {
        $room_password = Room::find($room_id)->password;
        $room_image = RoomImage::where('room_id', $room_id)->offset($number)->first('image');

        if (is_null($room_image)) {
            abort(404);
        }

        if (is_null($room_password)) {
            $room_image = RoomImage::where('room_id', $room_id)->offset($number)->first('image');
            abort_unless(Storage::exists($room_image->image), 404);
            return response()->file(Storage::path($room_image->image));
        } else if (session()->get('auth_room_id') == $room_id) {

            $room_image = RoomImage::where('room_id', $room_id)->offset($number)->first('image');

            abort_unless(Storage::exists($room_image->image), 404);
            return response()->file(Storage::path($room_image->image));
        } else {
            abort(404);
        }
    }

    public function downloadRoomFile($room_id, $file_name)
    {
        $file_path = 'roomFiles/RoomID:' . $room_id . '/' . $file_name;
        abort_unless(Storage::exists($file_path), 404);

        $mimeType = Storage::mimeType($file_path);

        $headers = [['Content-Type' => $mimeType]];

        return Storage::download($file_path, $file_name, $headers);
    }



    public function storeImage($image_file, $image_count, $room_id)
    {
        if (isset($image_file) && isset($room_id) && isset($image_count)) {
            //拡張子を取得
            $extension = $image_file->getClientOriginalExtension();
            //画像を保存して、そのパスを$imgに保存　第三引数に'local'を指定
            $img = $image_file->storeAs('roomImages/RoomID:' . $room_id, 'no' . $image_count . '.' . $extension, ['disk' => 'local']);
            return $img;
        }
    }

    public function storeFile($file, $room_id)
    {
        $file_name = $file->getClientOriginalName();

        //同じ名前のファイルがアップロードされたら名称に(n)をつけ足す
        $count = 0;
        $extension = $file->getClientOriginalExtension();
        $file_original_name = basename($file_name, '.' . $extension);
        while (Storage::exists('roomFiles/RoomID:' . $room_id . '/' . $file_name)) {
            $count++;
            $file_name = $file_original_name . '(' . $count . ')' . '.' . $extension;
        }

        $file->storeAs('roomFiles/RoomID:' . $room_id, $file_name, ['disk' => 'local']);
        return $file_name;
    }


    public function createRoom(CreateRoomRequest $request)
    {
        $room = new Room;

        if ($room->where('user_id', Auth::id())->where('posted_at', null)->count() >= 3) {
            return redirect('home')->with('error_message', '同時に開設できるルームは３つまでです。ルームを保存するか削除して下さい');
        }
        //roomsテーブルへ保存
        $room->user_id =  Auth::user()->id;
        $room->title = $request->title;
        $room->description = $request->description;
        if ($request->has('create_password')) {
            $room->password = Hash::make($request->create_password);
        };

        $room->save();

        if ($request->has('create_password')) {
            session()->put('auth_room_id', $room->id);
        };

        //room_imagesテーブルへ保存
        if ($request->has('room_images')) {
            foreach ($request->file("room_images") as $index => $room_image) {
                $image_count = $index;
                $image = new RoomImage;
                $image->room_id = $room->id;
                $image->image = $this->storeImage($room_image, $image_count, $room->id);
                $image->save();
            }
        }


        if ($request->has('matches')) {
            foreach ($request->matches as $match) {
                $tag = TagController::storeTag($match);
                $room->tags()->syncWithoutDetaching($tag->id);
            }
        }

        return redirect(route('enterRoom', [
            'room_id' => $room->id,
        ]));
    }


    public function removeRoom(Request $request)
    {
        if (is_null($request->room_id)) {
            return redirect('home')->with('error_message', 'エラーが発生しました');
        }
        $room_id = $request->room_id;
        if (Room::where('id', $room_id)->doesntExist()) {
            return redirect('home')->with('error_message', 'ルーム:' . $room_id . 'は存在しません');
        }

        $room = Room::find($room_id);

        if ($room->user_id != Auth::id()) {
            return redirect('home')->with('error_message', 'ログインユーザーとルームの作成者が一致しません');
        }

        $room_tags = $room->tags()->get();

        foreach ($room_tags as $room_tag) {
            if (Tag::where('id', $room_tag->pivot->tag_id)->doesntExist()) {
                return redirect('home')->with('error_message', 'tag エラー');
            }

            $tag = Tag::find($room_tag->pivot->tag_id);
            if ($tag->number <= 1) {
                $tag->delete();
            } else {
                $tag->update([
                    'number' => $tag->number - 1
                ]);
            }
        }

        $room->delete();
        event(new RemoveRoom($room_id));
        Storage::disk('local')->deleteDirectory('/roomImages/RoomID:' . $room_id);
        return redirect('home')->with('action_message', 'ルーム:' . $room_id . 'が削除されました');
    }
}
