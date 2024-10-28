<?php

namespace Tests\Feature\API;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @return void
     ** @test
     */
    /** @test */
    public function can_authenticate()
    {
       $res = $this->json('post','api/user-login',[
           'email' => User::factory()->create()->email,
           'password' =>'password'
       ]);
       $res->assertStatus(200)->assertJsonStructure(['data' => ['token']]);
    }
}
