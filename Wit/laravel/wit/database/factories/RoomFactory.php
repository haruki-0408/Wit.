<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function confrigure()
    {
        return $this->hasRoomTags;
    }

    public function definition()
    {
        return [
            'user_id'=>User::factory(),
            'title'=>$this->faker->text(20),
            'description'=>$this->faker->realText(400),
            'password'=> null ,
        ];
    }
}
