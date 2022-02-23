<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DBクエリでまずはシーディング
        DB::table('rooms')->insert([ 
            'user_id'=>'1',
            'title'=>'TestRoom1',
            'description'=>'TestRoom1シーディングの確認とパスワード設定の確認を兼ね備えた全テーブル確認'
        ]);

        DB::table('rooms')->insert([ 
            'user_id'=>'5',
            'title'=>'TestRoom2',
            'description'=>'TestRoom2シーディングの確認とパスワード設定の確認を兼ね備えた全テーブル確認'
        ]);
    }
}
