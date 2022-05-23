<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Tag;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    

    public function definition()
    {
        $tag_array =[
            'ac0df662-45ff-4053-aedf-de4515901373', 
            '00d2a7b0-9fc7-44fe-8674-6d9da79f56c7',
            '05ff0da8-8b85-4996-937c-157bb3e2f034',
            'fc755d2c-3192-41d1-9758-f86ae439475f',
            'f26e4154-0a95-49c6-9ae8-3f4946070f9d',
            'e7af72fb-c56a-4fd3-8775-a0c74fa07abe',
            'ea9d5f81-8db7-4987-8c47-c350005e4c1f',
            'dc963050-1acb-4f2e-bbba-afa0deb57601',
        ];

        $tag_id = array_rand($tag_array,1);
    
        return [
            'room_id' => Room::factory(),
            'tag_id'=> $tag_array[$tag_id],
        ];
    }
}
