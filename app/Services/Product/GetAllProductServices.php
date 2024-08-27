<?php

namespace App\Services\Product;


use App\Services\Service;
use App\Repository\Eloquent\ProductRepositoryEloquent;
use Illuminate\Database\Eloquent\Collection;

class GetAllProductServices extends Service
{
    private ProductRepositoryEloquent $productRepository;
    public function __construct(
        ProductRepositoryEloquent $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }
    public function execute():int|Collection
    {
        return  $this->productRepository->all();;
    }
}
