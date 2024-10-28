<?php

namespace Tests\Feature\API;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @return void
     ** @test
     */
    /** @test */
    public function can_place_order()
    {
        $token = User::factory()->create()->createToken('user',['user'])->plainTextToken;
        $items = [
            [
                'product_id' =>  Product::factory()->create(['stock' => random_int(100,200)])->id,
                'qty' => random_int(10,100),
            ],[
                'product_id' =>  Product::factory()->create(['stock' => random_int(100,200)])->id,
                'qty' => random_int(10,100),
            ],[
                'product_id' =>  Product::factory()->create(['stock' => random_int(100,200)])->id,
                'qty' => random_int(10,100),
            ]
        ];
        $response = $this->json('post','api/place-order',['items' => $items],['Authorization' => 'Bearer '.$token]);
        $order_id = json_decode($response->getContent(),true)['data']['order_id'];
        $response->assertJsonStructure(['data' => ['order_id'],'message'])
        ->assertStatus(201);
        $this->assertDatabaseHas('orders',[
            'id' => $order_id,
        ]);

    }
}
