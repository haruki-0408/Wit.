<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoomImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_images')->insert([
            'room_id' => '1',
            'image'=>'/images/sample01.JPG',
        ]);


        DB::table('room_images')->insert([
            'room_id' => '1',
            'image'=>'/images/sample03.JPG',
        ]);

        DB::table('room_images')->insert([
            'room_id' => '2',
            'image'=>'/images/sample05.PNG',
        ]);
    }
}
