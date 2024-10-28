<?php

namespace Tests\Feature\API;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Faker\Factory;
use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     * @return void
     ** @test
     */
    /** @test */
    public function can_create_a_product()
    {
        $token = Admin::factory()->create()->createToken('admin',['admin'])->plainTextToken;
        $faker = Factory::create();
        $response = $this->json('post','api/products',[
            'name' => $name = $faker->company,
            'stock' => rand(1,100),
            'sku' => $sku = Str::uuid(),
             'price' => $price = random_int(10,100),
        ],['Authorization' => 'Bearer '.$token]);

        $response->assertJsonStructure(['data' => ['id','name','sku','price','stock'],'message'])->
        assertJson(['data' => [
            'name' => $name ,
            'sku' => $sku,
            'price' => $price,
        ]])->
        assertStatus(201);
        $this->assertDatabaseHas('products',[
            'name' => $name,
            'sku' => $sku,
            'price' => $price,
        ]);

    }
}
