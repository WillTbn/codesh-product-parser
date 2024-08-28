<?php

namespace App\Services\Product;

use App\DTOs\ProductDTO;
use App\Enums\ProductStatus;
use App\Exceptions\PatternMessageException;
use App\Models\Product;
use App\Services\Service;
use App\Repository\Eloquent\ProductRepositoryEloquent;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateProductServices extends Service
{
    private ProductRepositoryEloquent $productRepository;
    public ProductDTO $productDto;
    public ?Product $product;
    /**
     * Service constructor
     *
     * @param string|int $code
     */
    public function __construct(
        ProductRepositoryEloquent $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }
    public function setProductDto(array $product)
    {
        $this->productDto = new ProductDTO(...[
            'code' =>  $product['code'],
            'imported_t' => $product['imported_t']??null,
            'url' => $product['url']??null,
            'creator'=>$product['creator']??null,
            'created_t'=>$product['created_t']??null,
            'last_modified_t'=>$product['last_modified_t']??null,
            'product_name'=>$product['product_name']??null,
            'quantity'=>$product['quantity']??null,
            'brands'=>$product['brands']??null,
            'categories'=>$product['categories']??null,
            'labels'=>$product['labels']??null,
            'cities' =>$product['cities']??null,
            'purchase_places'=>$product['purchase_places']??null,
            'stores'=>$product['stores']??null,
            'ingredients_text'=>$product['ingredients_text']??null,
            'traces'=>$product['traces']??null,
            'serving_size'=>$product['serving_size']??null,
            'serving_quantity'=>$product['serving_quantity']??null,
            'nutriscore_score'=>$product['nutriscore_score']??null,
            'nutriscore_grade'=>$product['nutriscore_grade']??null,
            'main_category'=>$product['main_category']??null,
            'image_url' => $product['image_url']??null,
            'status' =>ProductStatus::from($product['status']),
        ]);
    }
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
    public function getProduct():Product
    {
        return $this->product;
    }
    public function getProductDto():ProductDTO
    {
        return $this->productDto;
    }

    /**
     * execute from product update
     * @return UpdateProductServices|PatternMessageException
     */
    public function execute():UpdateProductServices|PatternMessageException
    {
        try{
            $reposity = $this->productRepository->update($this->getProductDto());
            $this->setProduct($reposity);
            return $this;
        }catch(Exception $e){
            Log::error('Error :'.json_encode($e));
            throw new PatternMessageException(message:'Erro ao atualiza registro.');
        }
    }
}
