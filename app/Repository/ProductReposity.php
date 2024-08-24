<?php

namespace App\Repository;

use App\DTOs\ProductDTO;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductReposity
{
    public function all():int|Collection;
    public function getByCode(int $code):?Product;
    public function save(ProductDTO $product):void;
    public function delete(int $code):void;
}
