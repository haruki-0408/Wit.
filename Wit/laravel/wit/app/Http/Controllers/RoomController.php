<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\AuthPasswordRequest;
use App\Events\UserSessionChanged;
use App\Events\SendMessage;
use App\Models\User;
use App\Models\Room;
use App\Models\Tag;
use App\Models\RoomImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class RoomController extends Controller
{
    /*
    public function index()
    {
        $items = Room::all();
        return view('wit.ShowDatabase.showRoom', ['rooms' => $items]);
    }*/

    protected function searchRoom(Request $request)
    {
        $query = Room::query();
        $second_query = Room::query();
        //queryを２つ用意しないとオーバーライドされてしまう


        switch ($request->searchType) {
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



        if ($request->checkImage != 'false') {
            $query->doesntHave('roomImages');
            $second_query->doesntHave('roomImages');
        }

        if ($request->checkTag != 'false' && $request->searchType != 'tag') {
            $query->doesntHave('tags');
            $second_query->doesntHave('tags');
        }

        if ($request->checkPassword != 'false') {
            $query->searchRoomPassword();
            $second_query->searchRoomPassword();
        }

        if ($request->checkAnswer != 'false') {
            $query->has('answer');
            $second_query->has('answer');
        }


        if (isset($request->room_id)) {
            if (mb_strlen($request->room_id) == 26) {
                $room_id = $request->room_id;
                $rooms = $query->where('id', '<', $room_id)->orderBy('id', 'desc')->with(['user', 'tags'])->take(10)->get();
            } else {
                abort(404);
            }
        } else {
            $rooms = $query->orderBy('id', 'desc')->with(['user', 'tags'])->take(15)->get();
        }


        $rooms->map(function ($each) use ($second_query) {
            $type = Room::buttonTypeJudge($each->id, $second_query);
            $each['type'] = $type['type'];

            if ($type['no_get_more']) {
                $each['no_get_more'] = $type['no_get_more'];
            }
            return $each;
        });

        foreach ($rooms as $room) {

            $room->user->id = Crypt::encrypt($room->user->id);
            $room->user_id = Crypt::encrypt($room->user_id);

            if (isset($room->password)) {
                $room->password = 'yes';
            }
        }
        //return $rooms;
        return response()->Json($rooms);
    }


    public static function getRoomInfo($room_id = null) //引数省略可能なメソッドにしてページ読み込み時と追加読み込み時に分けている
    {
        if (is_null($room_id)) {
            $rooms = Room::with(['user', 'tags'])->take(15)->get();
        } else {
            if (mb_strlen($room_id) == 26) {
                $rooms = Room::where('id', '<', $room_id)->orderBy('id', 'DESC')->with(['user', 'tags'])->take(10)->get();
            } else {
                abort(404);
            }
        }

        $rooms->map(function ($each) {
            $type = Room::buttonTypeJudge($each->id);
            $each['type'] = $type['type'];

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
        if (mb_strlen($request->room_id) == 26) {
            $room_id = $request->room_id;
        } else {
            return back()->with('error_message', 'ルーム:' . $request->room_id . 'は存在しません');
        }

        $room = Room::find($room_id);
        $room_password = $room->password;
        event(new UserSessionChanged($room_id));
        $auth_user = Auth::user();

        if (isset($request->enterPass) && isset($room_password)) {
            if (Hash::check($request->enterPass, $room_password)) {
                $room_info = Room::with(['user:id,name,profile_image', 'tags:name,number'])->find($room_id);
                $count_image_data = RoomImage::where('room_id', $room_id)->get('image')->count();
                session()->put('auth_room_id', $room_id);
                return view('wit.room', [
                    'room_info' => $room_info,
                    'count_image_data' => $count_image_data,
                    'auth_user' => $auth_user,
                ]);
            } else {
                return back()->with('error_message', 'パスワードが違います');
            }
        } else {
            return back()->with('error_message', 'パスワードが不正入力されています');
        }
    }

    public function enterRoom($room_id)
    {
        event(new UserSessionChanged($room_id));
        $auth_user = Auth::user();

        if (mb_strlen($room_id) != 26) {
            return back()->with('error_message', 'ルーム:' . $room_id . 'は存在しません');
        }

        if (Room::where('id', $room_id)->exists()) {
            $room_info = Room::with(['user:id,name,profile_image', 'tags:name,number'])->find($room_id);

            $count_image_data = RoomImage::where('room_id', $room_id)->get('image')->count();

            if (is_null($room_info->password)) {
                return view('wit.room', [
                    'room_info' => $room_info,
                    'count_image_data' => $count_image_data,
                    'auth_user' => $auth_user,
                ]);
            } else if ((session()->get('auth_room_id') == $room_id)) {
                return view('wit.room', [
                    'room_info' => $room_info,
                    'count_image_data' => $count_image_data,
                    'auth_user' => $auth_user,
                ]);
            } else {
                return redirect('home')->with('error_message', 'パスワード付きのルームです');
            }
        } else {
            return redirect('home')->with('error_message', 'ルーム:' . $room_id . 'は存在しません');
        }
    }

    public function exitRoom(Request $request)
    {
        $room_id = $request->room_id;
        $user_name = $request->user_name;
        $user_id = $request->user_id;
        if (Room::where('id', $room_id)->exists()) {
            $room = Room::find($room_id);
            $room->roomUsers()->updateExistingPivot($user_id,['exited_at' => Carbon::now()]);
            return response()->Json($user_name.'Exited');
        }
        return response()->Json('Exited Error');
    }

    public function receiveMessage(Request $request)
    {
        $rules = [
            'message' => 'required|max:400',
        ];

        $message = [
            'message.required' => 'メッセージを入力して下さい',
            'message.max' => 'メッセージは最大400文字までです',
        ];

        $request->validate($rules,$message);

        $user = User::find($request->user()->id);
        $user->roomChat()->attach($request->room_id, ['message' => $request->message]);

        event(new SendMessage($request->room_id,$request->user(),$request->message));
        return response()->Json('Message broadcast');
    }

    public function roomChatSort($room_id){
        $room = new Room;
        $room_chat = $room->find($room_id)->roomChat;
        foreach($room_chat as $chat){
            
        }
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

        $query = $user->rooms();

        if (is_null($room_id)) {
            $post_rooms = $user->rooms()->orderBy('id', 'desc')->with(['user', 'tags'])->take(10)->get();
        } else {
            $post_rooms = $user->rooms()->orderBy('id', 'desc')->where('id', '<', $room_id)->with(['user', 'tags'])->take(10)->get();
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
            $type = Room::buttonTypeJudge($each->id, null, $list_query);
            $each['type'] = $type['type'];

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
        if (mb_strlen($add_room_id) == 26) {
            $room_id = $add_room_id;
        } else {
            $error_message = 'ルーム:' . $add_room_id . 'は存在しません';
        }

        if (isset($room_id)) {
            $message_type = Room::addListRoom($room_id);
            switch ($message_type) {
                case 0:
                    $error_message = 'このルームは既にリストに追加されています';
                    break;
                case 1:
                    $message = 'リストにルームを追加しました';
                    break;
                case 2:
                    $error_message = 'ルーム:' . $room_id . 'は存在しません';
                    break;
                case 3:
                    $error_message = 'エラーが発生しました';
            }

            if (isset($message)) {
                return response()->Json(["message" => $message]);
            } else {
                return response()->Json(["error_message" => $error_message]);
            }
        }
    }

    public function actionRemoveListRoom($remove_room_id)
    {
        if (mb_strlen($remove_room_id) == 26) {
            $room_id = $remove_room_id;
        } else {
            $error_message = 'ルーム:' . $remove_room_id . 'は存在しません';
        }

        if (isset($room_id)) {
            $message_type = Room::removeListRoom($room_id);
            switch ($message_type) {
                case 0:
                    $error_message = 'このルームはリストに登録されていません';
                    break;
                case 1:
                    $message = 'リストからルームを削除しました';
                    break;
                case 2:
                    $error_message = 'ルーム:' . $room_id . 'は存在しません';
                    break;
                case 3:
                    $error_message = 'エラーが発生しました';
            }

            if (isset($message)) {
                return response()->Json(["message" => $message]);
            } else {
                return response()->Json(["error_message" => $error_message]);
            }
        }
    }

    //ルーム画像だけは別のメソッドで返す。　不正アクセス対策
    public function showRoomImage($room_id, $number)
    {
        $room_password = Room::find($room_id)->password;

        if (is_null($room_password)) {
            $room_image = RoomImage::where('room_id', $room_id)->offset($number)->first('image');

            if (is_null($room_image)) {
                abort(404);
            } elseif (Storage::exists($room_image->image)) {
                return response()->file(Storage::path($room_image->image));
            } else {
                abort(404);
            }
        } else if (session()->get('auth_room_id') == $room_id) {

            $room_image = RoomImage::where('room_id', $room_id)->offset($number)->first('image');

            if (is_null($room_image)) {
                abort(404);
            } elseif (Storage::exists($room_image->image)) {
                return response()->file(Storage::path($room_image->image));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }



    public function storeImage($image_file, $image_count, $room_id)
    {
        if (isset($image_file)) {
            //拡張子を取得
            $extension = $image_file->getClientOriginalExtension();
            //画像を保存して、そのパスを$imgに保存　第三引数に'local'を指定
            $img = $image_file->storeAs('roomImages/RoomID:' . $room_id, 'no' . $image_count . '.' . $extension, ['disk' => 'local']);
            return $img;
        }
    }

    public function storeTag($match)
    {
        $match_trim = trim($match);
        $tag = Tag::UpdateOrCreate(['name' => $match_trim], ['name' => $match_trim, 'number' => DB::raw('number + 1')]);
        return $tag;
    }


    public function createRoom(CreateRoomRequest $request)
    {
        //$this->validate($request, Room::$rules);
        //$this->validate($request, Tag::$rules);

        $room = new Room;

        //roomsテーブルへ保存
        $room->user_id =  Auth::user()->id;
        $room->title = $request->title;
        $room->description = $request->description;
        if ($request->has('createPass')) {
            $room->password = Hash::make($request->createPass);
        };

        $room->save();


        if ($request->has('createPass')) {
            session()->put('auth_room_id', $room->id);
        };

        //room_chatテーブルへ保存
        $user = User::find($room->user_id);
        $user->roomChat()->attach($room->id, ['message' => $room->description]);

        //room_imagesテーブルへ保存
        if ($request->has('roomImages')) {
            foreach ($request->file("roomImages") as $index => $roomImage) {
                $image_count = $index;
                $room_image = new RoomImage;
                $room_image->room_id = $room->id;
                $room_image->image = $this->storeImage($roomImage, $image_count, $room->id);
                $room_image->save();
            }
        }


        if ($request->has('matches')) {
            foreach ($request->matches as $match) {
                $tag = $this->storeTag($match);
                $room->tags()->syncWithoutDetaching($tag->id);
            }
        }

        return redirect(route('enterRoom', [
            'id' => $room->id,
        ]));
    }


    public function removeRoom($room_id)
    {
        if (Room::where('id', $room_id)->exists()) {
            $room = Room::find($room_id);
            if ($room->user_id == Auth::id()) {
                $room_tags = $room->tags()->get();

                foreach ($room_tags as $room_tag) {
                    if (Tag::where('id', $room_tag->pivot->tag_id)->exists()) {
                        $tag = Tag::find($room_tag->pivot->tag_id);
                        if ($tag->number < 1) {
                            $tag->delete();
                        } else {
                            $tag->update([
                                'number' => $tag->number - 1
                            ]);
                        }
                    } else {
                        return back()->with('error_message', 'tag エラー');
                    }
                }

                $room->delete();

                Storage::disk('local')->deleteDirectory('/roomImages/RoomID:' . $room_id);
                return back()->with('action_message', 'ルーム:' . $room_id . 'が削除されました');
            } else {
                return back()->with('error_message', 'ログインユーザーとルームの作成者が一致しません');
            }
        } else {
            return back()->with('error_messge', 'ルーム:' . $room_id . 'は存在しません');
        }
    }
}

/* テストように作ったもの　本番には不要
public function userGet()
    {
        $items = RoomUser::with('User')->get();
        return view('wit.ShowDatabase.showRoomUser', ['room_users' => $items]);
    }

    public function getUser()
    {
        $users = User::select('name', 'email')->get();
        return $users;
    }

    public function imageGet()
    {
        $items = RoomImage::with('Room')->get();
        return view('wit.ShowDatabase.showRoomImage', ['room_images' => $items]);
    }

    public function chatGet()
    {
        $items = RoomChat::with('User')->with('Room')->get();
        return view('wit.ShowDatabase.showRoomChat', ['room_chat' => $items]);
    }
*/
