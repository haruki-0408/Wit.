<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Subscribe;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
   public function __invoke($email_token)
   {
        $email_address = base64_decode($email_token);
        $user = User::where('email_verified_token', $email_token)->first();
    
        // 使用可能なトークンか
        if (User::where('email_verified_token', $email_token)->doesntExist()) {
            return redirect('/home')->with('error_message', '無効なトークンです');
        }

        $user = User::where('email_verified_token', $email_token)->first();
        // 本登録済みユーザーか
        if ($user->status == User::STATUS[2]) //REGISTER=2
        {
            //メールアドレスを更新
            $user->email = $email_address;
            $user->save();
            return redirect('/home')->with('action_message', 'メールアドレスを変更しました');
        }else{
            return redirect('/home')->with('error_message', 'エラーが発生したためメールアドレスを変更できませんでした');
        }
   }
}
