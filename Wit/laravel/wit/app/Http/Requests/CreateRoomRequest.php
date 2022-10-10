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
            'title' => 'required|max:30|string',
            'description' => 'required|max:500|string',
            'room_images.*' => 'image',
            'sum_image_size' => 'int|max:5120000',
            //ここはサイズではなくintの整数値で判断しているからサイズなら5120でいい
            'sum_image_count' => 'int|max:30',
            'matches.*' => 'max:20',
            'create_password' => 'max:50|confirmed|min:8'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Titleを入力してください',
            'title.max' => 'Titleは最大30文字以内です',
            'description.required' => 'Descriptionを入力してください',
            'description.max' => 'Descriptionは最大400文字以内です',
            'sum_image_size.max' => '画像サイズは合計5MBまでです',
            'sum_image_count.max' => '画像枚数は最大30枚までです',
            'room_images.*.image' => '画像形式以外はアップロードできません',
            'matches.*.max' => '1タグにつき最大20文字までです',
            'create_password.max' => 'passwordは最大50文字以内です',
            'create_password.min' => 'passwordは最小8文字からです',
            'create_password.confirmed' => 'passwordが一致しませんでした',
        ];
    }

    public function prepareForValidation()
    {
        if (isset($this->tag)) {
            preg_match_all('/([a-zA-Z0-9ぁ-んァ-ヶー-龠 ~!#$&()=@.,:%*{}¥?<>^|_\\\"\'\-\+]+);/u', $this['tag'], $matches);

            if (empty($matches[1])) {
                return $this->all();
            }

            foreach ($matches[1] as $index => $match) {
                $match = trim($match);
                if ($match !== "") {
                    $trim_matches[$index] = $match;
                }
            }
            if (isset($trim_matches)) {
                $matches = array_unique($trim_matches);
                $this->merge(['matches' => $matches]);
            }
        }

        return $this->all();
    }


    public function validationData()
    {
        $data = $this->all();
        if ($this->has('room_images')) {
            $sum_image_size = 0;
            $sum_image_count = count($this['room_images']);

            foreach ($this['room_images'] as $room_image) {
                $sum_image_size += filesize($room_image);
            }
            $data['sum_image_size'] = $sum_image_size;
            $data['sum_image_count'] = $sum_image_count;
        }
        return $data;
    }
}
