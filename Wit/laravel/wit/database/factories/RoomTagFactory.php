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
            '0aa14867-1129-4f16-afcd-41937ffe5538',
            '1434de9b-5ee9-48c6-be72-a6118644f48b',
            '166147b3-877a-4f1b-83c6-56e9e05337b3',
            '1946ff27-2f94-4931-bde9-978807d211d6',
            '1ed67ae4-eef2-45a5-a0aa-b368d6172e82',
            '22460936-747d-464e-ae59-335f1004ab08',
            '2957e413-0e89-47e0-9116-c39840202272',
            '29753fd2-f5fd-4b73-9810-2e57a4e32fa1',
            '6afa0578-462c-42c0-9c0c-ded06f211a0c',
            '60072e2a-cb2c-44d8-b431-c394065efe11',
        ];

        $tag_id = array_rand($tag_array,1);
    
        return [
            'room_id' => Room::factory(),
            'tag_id'=> $tag_array[$tag_id],
        ];
    }
}
