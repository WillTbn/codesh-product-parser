<?php
namespace App\Services\OpenFoodFacts;

use App\Enums\ProductStatus;
use App\Services\Service;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class ImportOFFServices extends Service
{
    private array $files;
    public function __construct(
        array $files
    )
    {
        $this->files = $files;
    }
    /**
     * files
     */
    public array $filesName =[];
    /**
     * URL complet filePath
     */
    public string $filePath;
    /**
     * limit
     */
    public ?int $limit = 50;

    public array $productData = [];

    /**
     * set FilesName
     */
    public function setFilesName()
    {
        $this->filesName = $this->files;
        // array_push($this->filesName, $this->files);
    }
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
     * get filesName
     * @return array
     */
    public function getFilesName():array
    {
        return $this->filesName;
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
    /**
     *
     */
    public function setProductDto()
    {

    }
    public function processLargeGz()
    {
        $tempFilePath = storage_path('app/temp_file.gz');
        $this->setFilePath('products_01.json.gz');

        // Baixando o arquivo da URL
        $response = Http::get($this->filePath);

        if ($response->successful()) {
            // Salvando o conteúdo do arquivo compactado
            file_put_contents($tempFilePath, $response->body());

            // Abrindo o arquivo .gz como um stream
            $gz = gzopen($tempFilePath, 'rb');

            $productCount = 0;
            $buffer = '';

            // Processando linha a linha
            while (!gzeof($gz)) {
                $line = gzgets($gz);

                // Adicionando a linha ao buffer
                $buffer .= $line;

                // Tentando decodificar o JSON no buffer
                $jsonProduct = json_decode($buffer, true);

                // Se decodificou com sucesso, processamos o produto
                if (json_last_error() === JSON_ERROR_NONE) {
                    // $product =json_encode($jsonProduct) ;
                    // Log::info('Produto: '.$jsonProduct['code']);
                    $this->setProductData($jsonProduct);

                    Log::info('Produto: '.json_encode($this->getProductData()));
                    $productCount++;

                    if ($productCount >= $this->limit) {
                        Log::info('Limite atingido: ' . $productCount);
                        break;
                    }

                    // Resetando o buffer para o próximo produto
                    $buffer = '';
                }
            }

            Log::info('Processamento concluído com ' . $productCount . ' produtos.');

            // Fechando o stream
            gzclose($gz);

            // Removendo arquivo temporário
            unlink($tempFilePath);
        } else {
            throw new \Exception('Falha ao baixar o arquivo da URL: ' . $this->filePath);
        }
    }
    public function execute()
    {
        $this->processLargeGz();
        return $this;
    }
}
