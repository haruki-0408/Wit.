<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_users')->insert([
            'room_id' => '1',
            'user_id'=>'4',
        ]);
        DB::table('room_users')->insert([
            'room_id' => '1',
            'user_id'=>'11',
        ]);
    }
}
