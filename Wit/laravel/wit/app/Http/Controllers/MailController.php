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
    public function subscribe(Request $request)
    {
        /*$validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users'
        ]);

        if ($validator->fails()) {
            return new JsonResponse(['success' => false, 'message' => $validator->errors()], 422);
        }

        $email = $request->all()['email'];
        $subscriber = Subscriber::create(
            [
                'email' => $email
            ]
        );
        
        if ($subscriber) {
            Mail::to($email)->send(new Subscribe($email));
            return new JsonResponse(
                [
                    'success' => true,
                    'message' => "Thank you for subscribing to our email, please check your inbox"
                ],
                200
            );
        }*/
    }
    public function testIndex()   //コンタクトフォームを表示
    {
        return view('wit.Emails.contact');
    }

    public function testSendMessage(Request $request)  //メールの自動送信設定
    {
        Mail::send('wit.Emails.test', [], function($data){
                $data   ->to('haruki21789@gmail.com')
                        ->subject('Wit Test');
        });

        return back()->withInput($request->only(['name']))
                     ->with('sent', '送信完了しました。');  //送信完了を表示
    }
}
