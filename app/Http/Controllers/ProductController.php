<?php

namespace App\Http\Controllers;

use App\Services\Product\GetAllProductServices;
use App\Services\Product\GetProductServices;
use App\Services\Product\TrashedProductServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private GetAllProductServices $getAllProductServices;
    private GetProductServices $getProductServices;
    private TrashedProductServices $trashedProductServices;
    public function __construct(
        GetAllProductServices $getAllProductServices,
        GetProductServices $getProductServices,
        TrashedProductServices $trashedProductServices
    )
    {
        $this->getAllProductServices = $getAllProductServices;
        $this->getProductServices = $getProductServices;
        $this->trashedProductServices = $trashedProductServices;
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
