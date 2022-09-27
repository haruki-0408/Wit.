<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\Subscribe;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $rules = [
            'name' => ['required', 'string', 'max:25'],
            'password' => ['required', 'string', 'min:8', 'max:255','confirmed'],
        ];

        $messages = [
            'name.required' => '名前を入力してください',
            'name.max' => '名前は最大25文字までです',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは半角英数字8文字以上必要です',
            'password.max' => 'パスワードは半角英数字最大255文字以内です',
            'password.confirmed' => 'パスワードが一致しませんでした',
        ];

        return Validator::make($data, $rules, $messages);
        /*return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);*/
    }

    public function beforeRegisterCheck(Request $request)
    {
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ];

        $messages = [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレス形式で入力してください',
            'email.max' => 'メールアドレスは最大255文字までです',
            'email.unique' => 'このメールアドレスは既に使用されています',
        ];
        $request->validate($rules,$messages);
        return $this->beforeRegister($request);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        /*
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);*/

        $user = User::create([
            'email' => $data['email'],
            'email_verified_token' => base64_encode($data['email']),
        ]);

        $email = new Subscribe($user);
        +Mail::to($user->email)->send($email);
    }

    public function showRegisterForm($email_token)
    {
        // 使用可能なトークンか
        if (!User::where('email_verified_token', $email_token)->exists()) {
            return view('auth.register')->with('message', '無効なトークンです。');
        }

        $user = User::where('email_verified_token', $email_token)->first();
        // 本登録済みユーザーか
        if ($user->status == User::STATUS[1]) //REGISTER=1
        {
            return view('auth.register')->with('message', 'すでに本登録されています。ログインして利用してください。');
        }
        // ユーザーステータス更新
        $user->status = User::STATUS[2];
        $user->email_verified_at = Carbon::now();
        if ($user->save()) {
            return view('auth.register-default', compact('email_token'));
        } else {
            return view('auth.register')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
        }
    }

    public function beforeRegister(Request $request)
    {
        event(new Registered($user = $this->create($request->all())));

        return view('auth.registered');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = User::where('email_verified_token',$request->email_token)->first();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }
}
