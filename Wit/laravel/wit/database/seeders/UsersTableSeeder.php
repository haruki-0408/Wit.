<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ユーザを３人作成し１人あたり３つの部屋を同時に作成する
        /*User::factory()->hasAttached(
                Room::factory()->count(3),
                ['message' => Str::random(20)]
            )->count(2)->create();
            */

        //成功する
        //User::factory()->has(Room::factory()->count(1))->count(2)->create(); 
    }
}
