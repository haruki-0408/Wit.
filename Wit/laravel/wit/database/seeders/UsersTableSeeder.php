<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomTag;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::factory()->count(10)->create();
        User::factory()
            ->count(10)
            ->has(Room::factory()->has(RoomTag::factory()->count(10)))
            ->create();
    }
}
