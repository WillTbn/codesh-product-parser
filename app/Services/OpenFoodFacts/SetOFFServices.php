<?php
namespace App\Services\OpenFoodFacts;

use App\DTOs\ProductDTO;
use App\Services\Service;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class SetOFFServices extends Service
{
    public function __construct(
        protected ProductDTO $produtDto
    )
    {

    }
    public function execute(){
        // vai lá

        return $this;
    }
}
