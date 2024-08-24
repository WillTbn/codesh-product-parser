<?php

namespace App\DTOs;

use App\Enums\ProductStatus;

class ProductDTO
{
    private int $code;
    private ProductStatus $status;
    private ?\DateTime $imported_t;
    private ?string $url;
    private ?string $creator;
    private int $created_t;
    private int $last_modified_t;
    private ?string $product_name;
    private ?string $quantity;
    private ?string $brands;
    private ?string $categories;
    private ?string $labels;
    private ?string $cities;
    private ?string $purchase_places;
    private ?string $stores;
    private ?string $ingredients_text;
    private ?string $traces;
    private ?string $serving_size;
    private ?float $serving_quantity;
    private ?int $nutriscore_score;
    private ?string $nutriscore_grade;
    private ?string $main_category;
    private ?string $image_url;

    public function __construct(
        int $code,
        ProductStatus $status,
        ?\DateTime $imported_t = null,
        ?string $url = null,
        ?string $creator = null,
        int $created_t,
        int $last_modified_t,
        ?string $product_name = null,
        ?string $quantity = null,
        ?string $brands = null,
        ?string $categories = null,
        ?string $labels = null,
        ?string $cities = null,
        ?string $purchase_places = null,
        ?string $stores = null,
        ?string $ingredients_text = null,
        ?string $traces = null,
        ?string $serving_size = null,
        ?float $serving_quantity = null,
        ?int $nutriscore_score = null,
        ?string $nutriscore_grade = null,
        ?string $main_category = null,
        ?string $image_url = null
    ) {
        $this->code = $code;
        $this->status = $status;
        $this->imported_t = $imported_t;
        $this->url = $url;
        $this->creator = $creator;
        $this->created_t = $created_t;
        $this->last_modified_t = $last_modified_t;
        $this->product_name = $product_name;
        $this->quantity = $quantity;
        $this->brands = $brands;
        $this->categories = $categories;
        $this->labels = $labels;
        $this->cities = $cities;
        $this->purchase_places = $purchase_places;
        $this->stores = $stores;
        $this->ingredients_text = $ingredients_text;
        $this->traces = $traces;
        $this->serving_size = $serving_size;
        $this->serving_quantity = $serving_quantity;
        $this->nutriscore_score = $nutriscore_score;
        $this->nutriscore_grade = $nutriscore_grade;
        $this->main_category = $main_category;
        $this->image_url = $image_url;
    }
    public function getCode(): int
    {
        return $this->code;
    }
    public function getStatus(): ProductStatus
    {
        return $this->status;
    }
    public function getImportedT(): ?\DateTime
    {
        return $this->imported_t;
    }
    public function getUrl(): ?string
    {
        return $this->url;
    }
    public function getCreator(): ?string
    {
        return $this->creator;
    }
    public function getCreatedT(): int
    {
        return $this->created_t;
    }
    public function getLastModifiedT(): int
    {
        return $this->last_modified_t;
    }
    public function getProductName(): ?string
    {
        return $this->product_name;
    }
    public function getQuantity(): ?string
    {
        return $this->quantity;
    }
    public function getBrands(): ?string
    {
        return $this->brands;
    }
    public function getCategories(): ?string
    {
        return $this->categories;
    }
    public function getLabels(): ?string
    {
        return $this->labels;
    }
    public function getCities(): ?string
    {
        return $this->cities;
    }
    public function getPurchasePlaces(): ?string
    {
        return $this->purchase_places;
    }
    public function getStores(): ?string
    {
        return $this->stores;
    }
    public function getIngredientsText(): ?string
    {
        return $this->ingredients_text;
    }
    public function getTraces(): ?string
    {
        return $this->traces;
    }
    public function getServingSize(): ?string
    {
        return $this->serving_size;
    }
    public function getServingQuantity(): ?float
    {
        return $this->serving_quantity;
    }
    public function getNutriscoreScore(): ?int
    {
        return $this->nutriscore_score;
    }
    public function getNutriscoreGrade(): ?string
    {
        return $this->nutriscore_grade;
    }
    public function getMainCategory(): ?string
    {
        return $this->main_category;
    }
    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }
    // setters abaixo
    public function setCode(int $code): void
    {
        $this->code = $code;
    }
    public function setStatus(ProductStatus $status): void
    {
        $this->status = $status;
    }
    public function setImportedT(?\DateTime $imported_t): void
    {
        $this->imported_t = $imported_t;
    }
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }
    public function setCreator(?string $creator): void
    {
        $this->creator = $creator;
    }
    public function setCreatedT(int $created_t): void
    {
        $this->created_t = $created_t;
    }
    public function setLastModifiedT(int $last_modified_t): void
    {
        $this->last_modified_t = $last_modified_t;
    }
    public function setProductName(?string $product_name): void
    {
        $this->product_name = $product_name;
    }
    public function setQuantity(?string $quantity): void
    {
        $this->quantity = $quantity;
    }
    public function setBrands(?string $brands): void
    {
        $this->brands = $brands;
    }
    public function setCategories(?string $categories): void
    {
        $this->categories = $categories;
    }
    public function setLabels(?string $labels): void
    {
        $this->labels = $labels;
    }
    public function setCities(?string $cities): void
    {
        $this->cities = $cities;
    }
    public function setPurchasePlaces(?string $purchase_places): void
    {
        $this->purchase_places = $purchase_places;
    }
    public function setStores(?string $stores): void
    {
        $this->stores = $stores;
    }
    public function setIngredientsText(?string $ingredients_text): void
    {
        $this->ingredients_text = $ingredients_text;
    }
    public function setTraces(?string $traces): void
    {
        $this->traces = $traces;
    }
    public function setServingSize(?string $serving_size): void
    {
        $this->serving_size = $serving_size;
    }
    public function setServingQuantity(?float $serving_quantity): void
    {
        $this->serving_quantity = $serving_quantity;
    }
    public function setNutriscoreScore(?int $nutriscore_score): void
    {
        $this->nutriscore_score = $nutriscore_score;
    }
    public function setNutriscoreGrade(?string $nutriscore_grade): void
    {
        $this->nutriscore_grade = $nutriscore_grade;
    }
    public function setMainCategory(?string $main_category): void
    {
        $this->main_category = $main_category;
    }
    public function setImageUrl(?string $image_url): void
    {
        $this->image_url = $image_url;
    }
}
