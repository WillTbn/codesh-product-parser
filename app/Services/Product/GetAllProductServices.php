<?php

namespace App\Services\Product;


use App\Services\Service;
use App\Repository\Eloquent\ProductRepositoryEloquent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class GetAllProductServices extends Service
{
    public int $perPage = 10;
    private ProductRepositoryEloquent $productRepository;
    public function __construct(
        ProductRepositoryEloquent $productRepository
    )
    {
        $this->productRepository = $productRepository;
    }
    public function execute():LengthAwarePaginator
    {
        return  $this->productRepository->all($this->perPage);
    }
}
