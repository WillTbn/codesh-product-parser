<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_get_products_all()
    {
        $user = User::factory()->create();
        Product::factory(2)->create();

        $response = $this->actingAs($user)->get(route('products.store'));
        $response->assertStatus(200)
        ->assertJsonStructure([
            'products',
        ]);
    }
    public function test_get_product_by_code()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get(route('products.index', ['code'=>$product->code]));
        $response->assertStatus(200)
        ->assertJsonStructure([
            'product',
        ]);
    }
}
