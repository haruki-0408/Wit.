<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomChatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_chat')->insert([
            'room_id' => '1',
            'user_id' => '3',
            'message'=>'こんにちはテストメッセージ1です!',
        ]);


        DB::table('room_chat')->insert([
            'room_id' => '1',
            'user_id' => '6',
            'message'=>'こんにちはテストメッセージ2です!',
        ]);

        DB::table('room_chat')->insert([
            'room_id' => '2',
            'user_id' => '8',
            'message'=>'こんにちはテストメッセージ3です!',
        ]);
    }
}
