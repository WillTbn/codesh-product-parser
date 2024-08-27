<?php
namespace App\Services\OpenFoodFacts;

use App\Enums\ProductStatus;
use App\Services\Product\CreateProductServices;
use App\Services\Service;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class ImportOFFServices extends Service
{
    /**
     * filaname .gz from get
     */
    public string $fileName;
    /**
     * URL complet filePath
     */
    public string $filePath;
    /**
     * limit
     */
    public ?int $limit = 100;
    /**
     * variable with datas product
     */
    public array $productData = [];
    public function setFilePath(string $name)
    {
        $this->filePath = config('openfoodfacts.url').$name;
    }
    /**
     * setando the array product and get datas
     */
    public function setProductData(array $product){
        $this->productData = Arr::only($product, [
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
            'cities' ,
            'purchase_places',
            'stores',
            'ingredients_text',
            'traces',
            'serving_size',
            'serving_quantity',
            'nutriscore_score',
            'nutriscore_grade',
            'main_category',
            'image_url'
        ]);
        $this->productData[] = Arr::add($this->productData, 'imported_t', now());

        $this->productData[] = Arr::add(  $this->productData, 'status', Arr::random(ProductStatus::forSelectName()));
    }
    /**
     * set filaName
     */
    public function setFileName(string $name)
    {
        $this->fileName  = $name;
    }
    /**
     * get filesName
     * @return string
     */
    public function getFileName():string
    {
        return $this->fileName;
    }
    /**
     * get filepath
     */
    public function getFilePath(){
        return $this->filePath;
    }
    public function getProductData()
    {
        return $this->productData;
    }
    public function processLarge()
    {
         // Início do processo
        $tempFilePath = storage_path('app/temp_file.gz');

        $this->setFilePath($this->getFileName());
        // Baixando o arquivo da URL
        $response = Http::get($this->getFilePath());
        if(!$response->successful()){
            throw new \Exception('Falha ao baixar o arquivo da URL: ' . $this->getFilePath());
        }
        if ($response->successful()) {
            // Salvando o conteúdo do arquivo compactado
            file_put_contents($tempFilePath, $response->body());

            $gz = gzopen($tempFilePath, 'rb');

            $productCount = 0;
            $buffer = '';

            while (!gzeof($gz)) {
                $line = gzgets($gz);

                $buffer .= $line;

                $jsonProduct = json_decode($buffer, true);

                if (json_last_error() === JSON_ERROR_NONE) {

                    $this->setProductData($jsonProduct);
                    $productDTO = new SetOFFServices();
                    $productDTO->setProduct($this->getProductData());
                    $productCreate = new CreateProductServices($productDTO->productDto);
                    $productCreate->execute();
                    // $this->setOFFServices->getProduct();
                    // Log::info('Produto: '.json_encode($productDTO->productDto->getCode()));
                    $productCount++;

                    if ($productCount >= $this->limit) {
                        Log::info('Limite atingido: ' . $productCount);
                        break;
                    }


                    $buffer = '';
                }
            }

            Log::info('Processamento concluído com ' . $productCount . ' produtos.');

            // Fechando o stream
            gzclose($gz);

            // Removendo arquivo temporário
            unlink($tempFilePath);
        }
        Log::info('Processamento concluído com ' . $productCount . ' produtos.');
    }
    public function execute()
    {
        $this->processLarge();
        return $this;
    }
}
