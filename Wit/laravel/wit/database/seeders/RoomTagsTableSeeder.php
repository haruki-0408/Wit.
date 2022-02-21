<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //DBクエリでまずはシーディング
        DB::table('room_tags')->insert([
            'room_id' => '1',
            'tag_id'=>'2',
        ]);
    }
}
