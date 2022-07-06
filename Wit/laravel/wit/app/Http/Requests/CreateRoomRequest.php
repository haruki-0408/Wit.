<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'home/createRoom') {
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
            'title' =>'required|max:30|string',
            'description' => 'required|max:400|string',
            'roomImages[]' => 'image|max:5120',
            //'tag' => '', 
            'createPass' => 'max:255|string'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Titleを入力してください',
            'title.max' => 'Titleは30文字以内です',
            'description.required' => 'Descriptionを入力してください',
            'description.max' => 'Descriptionは400文字以内です',
            'roomImages[].max' => '画像サイズは合計5MBまでです',
            'roomImages[].image' => '画像形式以外はアップロードできません',
            'createPass.max' => 'passwordは最大255文字です',
        ];
    }
}
