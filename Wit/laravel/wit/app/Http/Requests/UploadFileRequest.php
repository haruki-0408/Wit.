<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'home/room/chat/file') {
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
            'room_id' => 'required',
            'file' => 'required|file|max:10240|mimes:txt,csv,json,xml,htm,html,pdf,png,jpeg,gif,webp',
        ];
    }

    public function messages()
    {
        return [
            'room_id.required' => 'ルームIDが存在しません',
            'file.required' => 'ファイル送信失敗',
            'file.file' => 'ファイル形式を適切に選択して下さい',
            'file.max' => '最大アップロードサイズは10MBです',
            'file.mimes' => 'アップロードできないファイルです',
        ];
    }
}
