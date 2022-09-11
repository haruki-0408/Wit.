<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        echo '--'.env('APP_ENV').'--';
        echo '--'.env('DB_DATABASE').'--'; 
        echo '--'.env('DB_CONNECTION').'--';
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_loginFail()
    {
        $user = User::factory()->create();
        $this->post('/login', [
            'email'    => $user->email,
            'password' => 12345678,
        ]);

        $response = $this->get('/home');
    
        // リダイレクトでページ遷移してくるのでstatusは302
        $response->assertStatus(302);
        // リダイレクトで帰ってきた時のパス
        $response->assertRedirect('/login');
    }

    public function test_loginSuccess()
    {
        $user = User::factory()->create();
        $this->post('/login', [
            'email'    => $user->email,
            'password' => '12345678',
        ]);
        //$response = $this->actingAs($user)->get('/home');

        $response = $this->get('/home');
        //200が帰ってきてログイン成功しているか
        $response->assertStatus(200);
        // このユーザーがログイン認証されているか
        $this->assertAuthenticatedAs($user);
    }
}
