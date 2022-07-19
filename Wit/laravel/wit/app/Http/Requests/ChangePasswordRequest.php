<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'home/profile/settings/changePassword') {
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
            'currentPass' => 'required|password',
            'newPass' => 'required|confirmed|min:8|max:255|string',
        ];
    }

    public function messages()
    {
        return [
            'currentPass.required' => '現在のパスワードを入力して下さい',
            'currentPass.password' => '現在のパスワードと一致しませんでした',
            'newPass.required' => '新しいパスワードを入力して下さい',
            'newPass.confirmed' => 'パスワードが一致しませんでした',
            'newPass.min' => 'パスワードは最小８文字からです',
            'newPass.max' => 'パスワードは最大255文字です',
        ];
    }
}
