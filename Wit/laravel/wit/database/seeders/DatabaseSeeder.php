<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RoomsTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(RoomTagsTableSeeder::class);
        $this->call(RoomUsersTableSeeder::class);
        $this->call(RoomImagesTableSeeder::class);
        $this->call(RoomChatTableSeeder::class);

    }
}
