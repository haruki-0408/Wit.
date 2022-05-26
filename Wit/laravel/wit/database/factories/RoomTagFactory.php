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
            '0017d9cc-c748-451b-a65f-9c3c72c2feeb',
            '01dd0851-013e-4721-ad9d-0b67d3edb4c5',
            '0fded48c-2819-4abf-9dff-17e50660af84',
            '106afc6f-8baf-4102-9a34-86b814a14e39',
            '14073e9e-1243-4cf1-9791-e516c84c0604',
            '21f721b1-86b8-468f-8473-201d89875e40',
            '294d294a-c9ef-4630-a161-c4ab4dbec192',
            '2b9763cf-6a8d-48e6-bb15-19e5fb95860a',
            '2d13768f-fecd-430f-9e4e-9ad3d25b94a2',
            '5ec0a143-c9d4-4de4-aa21-c4a7f2ea42c1',
            '76bb73c4-d57d-4836-8a77-610d9cb33ce4',
            'ff3c6539-ccec-4abb-be53-e5254a21ee21',
        ];

        $tag_id = array_rand($tag_array,1);
    
        return [
            'room_id' => Room::factory(),
            'tag_id'=> $tag_array[$tag_id],
        ];
    }
}
