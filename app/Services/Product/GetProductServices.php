<?php

namespace App\Services\Product;

use App\DTOs\ProductDTO;
use App\Models\Product;
use App\Services\Service;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Repository\Eloquent\ProductRepositoryEloquent;

class GetProductServices extends Service
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
    public function setCode(int|string $code)
    {
        $this->code = $this->productRepository->getByCode($code);
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
