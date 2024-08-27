<?php
namespace App\Repository\Eloquent;

use App\DTOs\ProductDTO;
use App\Enums\ProductStatus;
use App\Models\Product;
use App\Repository\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductRepositoryEloquent implements ProductRepository
{
    public function all():int|Collection
    {
        $product = Product::all();
        return $product;
    }
    public function getByCode(int $code):?Product
    {
        $product = Product::where('code', $code)->first();
        return $product;
    }
    public function save(ProductDTO $product):void
    {
        Product::firstOrNew(
            ['code' => $product->getCode()],
            [
                'code' => $product->getCode(),
                'imported_t' => $product->getImportedT(),
                'status' => $product->getStatus(),
                'url' => $product->getUrl(),
                'creator' => $product->getCreator(),
                'created_t' => $product->getCreatedT(),
                'last_modified_t' => $product->getLastModifiedT(),
                'product_name' => $product->getProductName(),
                'quantity' => $product->getQuantity(),
                'brands' => $product->getBrands(),
                'categories' => $product->getCategories(),
                'labels' => $product->getLabels(),
                'cities' => $product->getCities(),
                'purchase_places' => $product->getPurchasePlaces(),
                'stores' => $product->getStores(),
                'ingredients_text' => $product->getIngredientsText(),
                'traces' => $product->getTraces(),
                'serving_size' => $product->getServingSize(),
                'serving_quantity' => $product->getServingQuantity(),
                'nutriscore_score' => $product->getNutriscoreScore(),
                'nutriscore_grade' => $product->getNutriscoreGrade(),
                'main_category' => $product->getMainCategory(),
                'image_url'=>$product->getImageUrl(),
            ]
        )->saveOrFail();
    }
    public function delete(int $code):void
    {
        Product::where('code', $code)->deleteOrFail();
    }
    public function trashed(int $code):?Product
    {
        $product = Product::where('code', $code)->first();
        $product->status = ProductStatus::Trash;
        $product->updateOrFail();
        return $product;
    }
}
