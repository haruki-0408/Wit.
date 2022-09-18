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
            'current_password' => 'required|password',
            'new_password' => 'required|confirmed|min:8|max:255|string|different:current_password',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => '現在のパスワードを入力して下さい',
            'current_password.password' => '現在のパスワードと一致しませんでした',
            'new_password.required' => '新しいパスワードを入力して下さい',
            'new_password.different'=> '現在のパスワードと同じものは設定できません',
            'new_password.confirmed' => '確認用パスワードと一致しませんでした',
            'new_password.min' => 'パスワードは最小８文字からです',
            'new_password.max' => 'パスワードは最大255文字です',
        ];
    }
}
