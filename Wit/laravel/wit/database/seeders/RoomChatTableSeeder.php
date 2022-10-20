<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class RoomChatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 999; $i++) {
            DB::table('room_chat')->insert([
                'room_id' => '01gag4sjgs0hth2m8z04kspb9c',
                'user_id' => '42670639-dc44-4bcb-98b1-85e01ca58e72',
                'message' => Str::random(20),
            ]);
        }
    }
}
