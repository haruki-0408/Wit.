<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChoiceRemarksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'home/room/chat/choice') {
            return true;
        } else {
            return false;
        }
    }

    public function rules()
    {
        return [
            'room_id' => 'required',
            'target_array' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'room_id.required' => 'ルームIDが存在しません',
            'target_array.required' => '配列が存在しません',
            'target_array.array' => '配列形式で送信して下さい',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
}
