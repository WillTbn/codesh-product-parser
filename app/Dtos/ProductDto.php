<?php

namespace App\DTOs;

use App\Enums\ProductStatus;

class ProductDTO
{
    public function __construct(
        public int $code,
        public ProductStatus $status,
        public ?\DateTime $imported_t = null,
        public ?string $url = null,
        public ?string $creator = null,
        public int $created_t,
        public int $last_modified_t,
        public ?string $product_name = null,
        public ?string $quantity = null,
        public ?string $brands = null,
        public ?string $categories = null,
        public ?string $labels = null,
        public ?string $cities = null,
        public ?string $purchase_places = null,
        public ?string $stores = null,
        public ?string $ingredients_text = null,
        public ?string $traces = null,
        public ?string $serving_size = null,
        public ?float $serving_quantity = null,
        public ?int $nutriscore_score = null,
        public ?string $nutriscore_grade = null,
        public ?string $main_category = null,
        public ?string $image_url = null
    ) {}
}
