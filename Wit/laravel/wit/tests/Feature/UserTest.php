<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;
   
   public function setUp(): void
   {
       dd(env('APP_ENV'), env('DB_DATABASE'), env('DB_CONNECTION'));
   }


    public function test_example()
    {
        $user = User::factory()->create();
        $this->post('/login', [
            'email'    => $user->email,
            'password' => $user->password,
        ]);

        $response = $this->get('/home');

        $response->assertStatus(200);
    }
}
