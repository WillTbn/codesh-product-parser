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
    public function update(ProductDTO $productDto):?Product
    {
        $product = Product::where('code', $productDto->getCode())->first();
        $product->imported_t = $productDto->getImportedT()??$product->imported_t;
        $product->status = $productDto->getStatus()??$product->status;
        $product->url = $productDto->getUrl()??$product->url;
        $product->creator = $productDto->getCreator()??$product->creator;
        $product->created_t = $productDto->getCreatedT()??$product->created_t;
        $product->last_modified_t = $productDto->getLastModifiedT()??$product->last_modified_t;
        $product->product_name = $productDto->getProductName()??$product->product_name;
        $product->quantity = $productDto->getQuantity()??$product->quantity;
        $product->brands = $productDto->getBrands()??$product->brands;
        $product->categories = $productDto->getCategories()??$product->categories;
        $product->labels = $productDto->getLabels()??$product->labels;
        $product->cities = $productDto->getCities()??$product->cities;
        $product->purchase_places = $productDto->getPurchasePlaces()??$product->purchase_places;
        $product->stores = $productDto->getStores()??$product->stores;
        $product->ingredients_text = $productDto->getIngredientsText()??$product->ingredients_text;
        $product->traces = $productDto->getTraces()??$product->traces;
        $product->serving_size = $productDto->getServingSize();
        $product->serving_quantity = $productDto->getServingQuantity()??$product->serving_quantity;
        $product->nutriscore_score = $productDto->getNutriscoreScore()??$product->nutriscore_score;
        $product->nutriscore_grade = $productDto->getNutriscoreGrade()??$product->nutriscore_grade ;
        $product->main_category = $productDto->getMainCategory()??$product->main_category;
        $product->image_url =$productDto->getImageUrl()??$product->image_url;
        $product->updateOrFail();
        return $product;
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
