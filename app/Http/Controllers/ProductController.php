<?php

namespace App\Http\Controllers;

use App\DTOs\ProductDTO;
use App\Http\Requests\ProductRequest;
use App\Services\Product\GetAllProductServices;
use App\Services\Product\GetProductServices;
use App\Services\Product\TrashedProductServices;
use App\Services\Product\UpdateProductServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private GetAllProductServices $getAllProductServices;
    private GetProductServices $getProductServices;
    private TrashedProductServices $trashedProductServices;
    private  UpdateProductServices $updateProductService;
    public function __construct(
        GetAllProductServices $getAllProductServices,
        GetProductServices $getProductServices,
        TrashedProductServices $trashedProductServices,
        UpdateProductServices $updateProductService
    )
    {
        $this->getAllProductServices = $getAllProductServices;
        $this->getProductServices = $getProductServices;
        $this->trashedProductServices = $trashedProductServices;
        $this->updateProductService = $updateProductService;
    }
    /**
     * @return JsonResponse
     */
    public function store()
    {

        $products = $this->getAllProductServices->execute();
        return new JsonResponse([
            'message' =>  'Lista de Produtos!',
            'products' => [
                'products' => $products->items(),
                'current_page' => $products->currentPage(),
                'total_pages' => $products->lastPage(),
                'total_products' => $products->total(),
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl()
                ]
            ],
            200
        );
    }
    /**
     * @param int|Product $code
     * @return JsonResponse
     */
    public function index(int $code)
    {
        $this->getProductServices->setCode($code);
        $this->getProductServices->execute();
        return new JsonResponse(
            ['message' =>  'Lista de Produtos!',  'product' => $this->getProductServices->getCode()],
            200
        );
    }

    /**
     * @param ProductRequest $request
     * @param int $code
     * @return JsonResponse
     */
    public function updated(ProductRequest $request, int $code)
    {
        $request['code'] = $code;
        $this->updateProductService->setProductDto( $request->only([
            'code',
            'url',
            'creator',
            'created_t',
            'last_modified_t',
            'product_name',
            'quantity',
            'brands',
            'categories',
            'labels',
            'cities',
            'purchase_places',
            'stores',
            'ingredients_text',
            'traces',
            'serving_size',
            'serving_quantity',
            'nutriscore_score',
            'nutriscore_grade',
            'main_category',
            'image_url',
            'status',
        ]));
        $this->updateProductService->execute();
        return new JsonResponse(
            ['message' =>  'Lista de Produtos!',  'product' => $this->updateProductService->getProductDto()],
            200
        );
    }
    /**
     * @param int|Product $code
     * @return JsonResponse
     */
    public function trashed(int $code)
    {
        $this->trashedProductServices->setCode($code);
        $this->trashedProductServices->execute();
        return new JsonResponse(
            ['message' =>  'Produto atualizar para trash, com sucesso!',  'product' => $this->trashedProductServices->getCode()],
            200
        );
    }
}
