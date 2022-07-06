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
            'description' => 'required|max:400|string',
            'roomImages.*' => 'image',
            'sumImageSize' => 'int|max:5120000',
            //ここはサイズではなくintの整数値で判断しているからサイズなら5120でいい
            'matches.*' => 'max:20',
            'createPass' => 'max:255|confirmed|min:8'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Titleを入力してください',
            'title.max' => 'Titleは30文字以内です',
            'description.required' => 'Descriptionを入力してください',
            'description.max' => 'Descriptionは400文字以内です',
            'sumImageSize.max' => '画像サイズは合計5MBまでです',
            'roomImages.*.image' => '画像形式以外はアップロードできません',
            'matches.*.max' => '1タグにつき最大20文字までです',
            'createPass.max' => 'passwordは最大255文字です',
            'createPass.min' => 'passwordは最小8文字からです',
            'createPass.confirmed' => 'passwordが一致しませんでした',
        ];
    }

    public function prepareForValidation()
    {
        if($this->has('tag')){
            preg_match_all('/([a-zA-Z0-9ぁ-んァ-ヶー-龠 ~!#$&()=@.,:%*{}¥?<>^|_\\\"\'\-\+]+);/u', $this['tag'], $matches);
            $this->merge(['matches' => $matches[1] ]);
        }

        return $this->all();
    }

    public function validationData()
    {
        if ($this->has('roomImages')) {
            $sum_image_size = 0;
            foreach ($this['roomImages'] as $roomImage) {
                $sum_image_size += filesize($roomImage);
            }

            $this->merge(['sumImageSize' => $sum_image_size]);
        }

        return $this->all();
    }
}
