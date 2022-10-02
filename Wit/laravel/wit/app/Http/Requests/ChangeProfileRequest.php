<?php

namespace App\Http\Requests;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeProfileRequest extends FormRequest
{
    /**
     * The URI to redirect to if validation fails.
     *
     * @var string
     */
    protected $redirect = '/home/profile/settings?ref=info';


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'home/profile/settings/changeProfile') {
            session()->put(['auth_user_id' => Auth::id()]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $auth_id = Auth::id();
        return [
            'name' => 'string|max:25',
            'message' => 'max:500',
            'image' => 'image|max:5120'
        ];
    }

    public function messages()
    {
        return [
            'name.string' => 'ユーザ名を適切に入力して下さい',
            'name.max' => '名前は最大25文字までです',
            'message.max' => 'プロフィールメッセージは最大500文字までです',
            'image.max' => '画像サイズは5MBまでです',
            'image' => '画像形式以外はアップロードできません',
        ];
    }

    
}
