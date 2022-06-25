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
            '68a87a3f-0ee4-4a4f-bf8a-4f31e45007e1',
        ];

        $tag_id = array_rand($tag_array,1);
    
        return [
            'room_id' => Room::factory(),
            'tag_id'=> $tag_array[$tag_id],
        ];
    }
}
