<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductModelTest extends TestCase
{
    private Product $product;

    use RefreshDatabase;
    protected function setUp() :void
    {
        parent::setUp();
        $this->product = Product::factory()->create(['price' => 50,'stock' => 10]);

    }
    /**
     * A basic unit test example.
     * @test
     */
    public function product_is_not_out_of_stock()
    {

        $this->assertNotEquals(0,$this->product->stock);
    }

    /**
     * A basic unit test example.
     * @test
     */
    public function product_price_is_less_than_200()
    {
        $this->assertLessThan(200,$this->product->price);
    }
}
