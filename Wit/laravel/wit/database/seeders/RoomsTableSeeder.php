<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Room;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*DBクエリでまずはシーディング
        DB::table('rooms')->insert([ 
            'user_id'=>'1',
            'title'=>'TestRoom1',
            'description'=>'TestRoom1シーディングの確認とパスワード設定の確認を兼ね備えた全テーブル確認'
        ]);

        DB::table('rooms')->insert([ 
            'user_id'=>'5',
            'title'=>'TestRoom2',
            'description'=>'TestRoom2シーディングの確認とパスワード設定の確認を兼ね備えた全テーブル確認'
        ]);*/
        $user_id = User::where('name','Test')->value('id');
        Room::factory()->count(15)->create(['user_id' => $user_id, 'posted_at' => Carbon::now()]);
    }
}
