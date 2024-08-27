<?php

namespace App\Http\Controllers;

use App\Services\Product\GetAllProductServices;
use App\Services\Product\GetProductServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private GetAllProductServices $getAllProductServices;
    private GetProductServices $getProductServices;
    public function __construct(
        GetAllProductServices $getAllProductServices,
        GetProductServices $getProductServices
    )
    {
        $this->getAllProductServices = $getAllProductServices;
        $this->getProductServices = $getProductServices;
    }
    /**
     * @return JsonResponse
     */
    public function store()
    {

        $productAll = $this->getAllProductServices->execute();
        return new JsonResponse(
            ['message' =>  'Lista de Produtos!',  'products' => $productAll],
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
}
