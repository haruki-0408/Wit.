<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(); 
    }


    public function test_show_profile()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        $user_id = Crypt::encrypt($this->user->id);
        $response = $this->get('/home/profile:'.$user_id);
        $response->assertStatus(200)->assertViewIs('wit.profile');
        $response->assertSee([ //response htmlに以下の文字列が含まれているか
            $this->user->profile_image,
            $this->user->name,
            $this->user->profile_message,
            'Open',
            'Post',
            'List User',
            'List Room',
            'Trend Tag',
        ]);
        $response->assertViewHasAll([ //responseに以下のデータが存在しているか
            'user_id',
            'type',
            'user_name',
            'profile_message',
            'profile_image',
        ]);
    }

    public function test_profile_settings()
    {
        $this->actingAs($this->user);  //userをログイン状態にする
        $user_id = Crypt::encrypt($this->user->id);
        $response = $this->get('/home/profile/settings?ref=info');
        $response->assertStatus(200)->assertViewIs('wit.Account.information-account');
        /*$response->assertViewHasAll([ //responseに以下のデータが存在しているか
            'user_id',
            'type',
            'user_name',
            'profile_message',
            'profile_image',
        ]);*/

        $response = $this->get('/home/profile/settings?ref=delete');
        $response->assertStatus(200)->assertViewIs('wit.Account.delete-account');

        $random_string = Str::random(10);
        $response = $this->get('/home/profile/settings?ref='.$random_string);
        $response->assertStatus(302)->assertRedirect('/home')->assertSessionHas(['error_message' => 'エラーが起きました']);
    }
}
