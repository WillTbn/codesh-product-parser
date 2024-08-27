<?php
namespace App\Services\OpenFoodFacts;

use App\DTOs\ProductDTO;
use App\Enums\ProductStatus;
use App\Services\Service;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class SetOFFServices extends Service
{
    /**
     *  ProductDTO $produtDto
    */
    public ProductDTO $productDto;
    /**
     * setando product
     * @param array $product
     */
    public function setProduct(array $product)
    {
        $this->productDto = $this->createProductDTO($product);
    }
    /**
     * retorn product to DTO
     * @return ProductDTO $productDto
     */
    public function getProduct(): ProductDTO
    {
        return $this->productDto;
    }
    public function createProductDTO(array $product):ProductDTO
    {
        return  new ProductDTO(...[
            'code' => $product['code'],
            'url' => $product['url'],
            'creator'=>$product['creator'],
            'created_t'=>$product['created_t'],
            'last_modified_t'=>$product['last_modified_t'],
            'product_name'=>$product['product_name'],
            'quantity'=>$product['quantity'],
            'brands'=>$product['brands'],
            'categories'=>$product['categories'],
            'labels'=>$product['labels'],
            'cities' =>$product['cities'],
            'purchase_places'=>$product['purchase_places'],
            'stores'=>$product['stores'],
            'ingredients_text'=>$product['ingredients_text'],
            'traces'=>$product['traces'],
            'serving_size'=>$product['serving_size'],
            'serving_quantity'=>(float)$product['serving_quantity'],
            'nutriscore_score'=>(int)$product['nutriscore_score'],
            'nutriscore_grade'=>$product['nutriscore_grade'],
            'main_category'=>$product['main_category'],
            'image_url' => $product['image_url'],
            'imported_t' => now(),
            'status' => ProductStatus::Published,

        ]);
    }
    public function execute():self
    {
        return $this;
    }
}
