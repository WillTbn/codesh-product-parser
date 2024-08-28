<?php

namespace App\Services\Product;

use App\DTOs\ProductDTO;
use App\Exceptions\PatternMessageException;
use App\Services\Service;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\ProductRepositoryEloquent;

class CreateProductServices extends Service
{
    /**
     *  ProductDto DataTranferObject
     *  @product
     */
    public ProductDTO $product;
    public function __construct(
        ProductDTO $product
    )
    {
        $this->product = $product;
    }
    /**
     * Execute from create or update product
     * @return CreateProductServices|PatternMessageException
     */
    public function execute(): CreateProductServices|PatternMessageException
    {
        try{
            $productReposity = new ProductRepositoryEloquent();
            $productReposity->save($this->product);
            return $this;
        }catch(Exception $e){
            Log::error('Erro : '.json_encode($e));
            throw new PatternMessageException(message:'Erro ao atualiza registro do produto.');
        }
    }
}
