<?php

namespace Tests\Feature\Products;

use App\Enums\ProductStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
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
    public function test_delete_product_status_trashed()
    {
        $user = User::factory()->create();
        Product::factory(4)->create();
        $getProduct = Product::factory()->create(['code'=> fake()->isbn10()]);
        $response = $this->actingAs($user)->delete(route('products.trashed', ['code'=>$getProduct->code]));
        $response->assertStatus(200)
        ->assertJsonStructure([
            'product',
        ]);
        $this->assertDatabaseHas('products', [
            'code' => $getProduct->code,
            'status' => ProductStatus::Trash
        ]);
    }
    public function test_put_product_updated()
    {
        $user = User::factory()->create();
        Product::factory(4)->create();

        $getProduct = Product::factory()->create(['code'=> fake()->isbn10()]);
        $response = $this->actingAs($user)->put(route('products.updated', $getProduct->code), [
            'status' => 'published',
            'imported_t' =>$getProduct->imported_t,
            'last_modified_t' => $getProduct->last_modified_t,
            'product_name' => $getProduct->product_name,
            'created_t' => $getProduct->created_t,
            'serving_size'=> 'madalena 2 333 31.7 g',
        ]);
        $response->assertStatus(200)
        ->assertJsonStructure([
            'product',
        ]);
        $this->assertDatabaseHas('products', [
            'code' => $getProduct->code,
            'status' => ProductStatus::Published,
            'serving_size'=> 'madalena 2 333 31.7 g',
        ]);
    }
}
