<?php

namespace App\Repository;

use App\DTOs\ProductDTO;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepository
{
    public function all():int|Collection;
    public function getByCode(int $code):?Product;
    public function save(ProductDTO $product):void;
    public function update(ProductDTO $product):?Product;
    public function delete(int $code):void;
    public function trashed(int $code):?Product;
}
