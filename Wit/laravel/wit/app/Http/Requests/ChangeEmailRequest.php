<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

class ChangeEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $redirect = '/home/profile/settings?ref=email';


    public function authorize()
    {
        if ($this->path() == 'home/profile/settings/changeEmail') {
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
        return [
            'email' => 'required|email|max:255|string|unique:users,email',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力して下さい',
            'email.email' => 'メールアドレス形式で入力してください',
            'email.max' => 'メールアドレスは最大255文字までです',
            'email.unique' => 'このメールアドレスは既に使用されています',
        ];
    }
}
