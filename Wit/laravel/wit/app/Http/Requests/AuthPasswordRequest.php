<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Room;
use Illuminate\Support\Facades\Hash;

class AuthPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'home/authRoomPassword' || $this->path() == 'home/profile/settings/authUserPassword') {
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
            'deletePass' => 'required_if:ref,delete|password',
            'infoPass' => 'required_if:ref,info|password',
            'enterPass' => 'required_with:room_id|boolean'
        ];
    }

    public function messages()
    {
        return [
            'deletePass.required_if' => 'パスワードを入力して下さい',
            'deletePass.password' => 'パスワードが一致しませんでした',
            'infoPass.required_if' => 'パスワードを入力して下さい',
            'infoPass.password' => 'パスワードが一致しませんでした',
            'enterPass.required_with' => 'パスワードを入力して下さい',
            'enterPass.boolean' => 'パスワードが一致しませんでした',
        ];
    }


    public function validationData()
    {
        $data= $this->all();
        if ($this->has('enterPass') && $this->has('room_id')) {
            $room = new Room;
            $room_id = $this->room_id;
            if ($room->where('id', $room_id)->exists()) {
                $room_password  = $room->find($room_id)->password;
                $enter_password = $this->enterPass;
                
                if (Hash::check($enter_password, $room_password)) {
                    $data['enterPass'] = true;
                }
            }
        }

        return $data;
    }
}
