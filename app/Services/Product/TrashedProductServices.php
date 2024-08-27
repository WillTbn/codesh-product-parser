<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Services\Service;
use App\Repository\Eloquent\ProductRepositoryEloquent;

class TrashedProductServices extends Service
{
    private ProductRepositoryEloquent $productRepository;
    public ?Product $code;
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
    public function setCode(int|string $product_code)
    {
        $this->code = $this->productRepository->trashed($product_code);
    }
    public function getCode():?Product
    {
        return $this->code;
    }
    public function execute()
    {
        $this;
    }
}
