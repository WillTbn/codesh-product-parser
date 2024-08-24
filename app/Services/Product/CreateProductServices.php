<?php

namespace App\Services\Product;

use App\DTOs\ProductDTO;
use App\Enums\ProductStatus;
use App\Repository\ProductReposity;
use App\Services\Service;
use Exception;

class CreateProductServices extends Service
{
    /**
     *  ProductDto DataTranferObject
     *  @product
     */
    public ProductDTO $product;

    private ProductReposity $productReposity;
    public function __construct(
        ProductReposity $productReposity,
        ProductDTO $product

    )
    {
        $this->productReposity = $productReposity;
        $this->product = $product;
    }
    /**
     * Execute from create or update product
     * @return CreateProductServices|Exception
     */
    public function execute(): CreateProductServices|Exception
    {
        // EXECUTE
        try{
            $this->productReposity->save($this->product);
            return $this;
        }catch(Exception $e){
            return response()->json([
                'message' => 'Erro no execute para cria ou atualiza produto!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
}
