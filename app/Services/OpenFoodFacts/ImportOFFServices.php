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
    public ?int $limit = 100;
    /**
     * variable with datas product
     */
    public array $productData = [];

    /**
     * variable with initial date process
     */
    public float|int $duration_process;
    /**
     * variable initial memory
     */
    public string $memory_initial;
    /**
     * variable memory finally
     */
    public string $memory_finally;
    /**
     * total memory usage
     */
    public string $memory_usage;
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
     * set duration process
     */
    public function setDurationProcess(float|int $seconds)
    {
        $this->duration_process = number_format($seconds, 2);
    }
    public function setMemoryInitial(float|int $startMemory)
    {
        $this->memory_initial = $this->formatBytes($startMemory);
    }
    public function setMemoryFinally(float|int $endMemory)
    {
        $this->memory_finally = $this->formatBytes($endMemory);
    }
    public function setMemoryUsage(float|int $peakMemory)
    {
        $this->memory_usage = $this->formatBytes($peakMemory);
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
    public function getDurationProcess()
    {
        return $this->duration_process;
    }
    public function getMemoryInitial()
    {
        return $this->memory_initial;
    }
    public function getMemoryFinally()
    {
        return $this->memory_finally;
    }
    public function getMemoryUsage()
    {
        return $this->memory_usage;
    }
    /**
     *
     */
    public function setProductDto()
    {

    }
    public function processLarge()
    {
         // Início do processo
        $startTime = microtime(true);
        $this->setMemoryInitial(memory_get_usage());
        $tempFilePath = storage_path('app/temp_file.gz');
        foreach($this->getFilesName() as $filename){
            $this->setFilePath($filename);
            // Baixando o arquivo da URL
            $response = Http::get($this->filePath);
            if(!$response->successful()){
                throw new \Exception('Falha ao baixar o arquivo da URL: ' . $this->filePath);
            }
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
            }
        }
        // Fim do processo
        $endTime = microtime(true);
        $this->setMemoryFinally(memory_get_usage());
        $this->setMemoryUsage(memory_get_peak_usage());

        // Calculando o tempo total do processo
        $this->setDurationProcess( $endTime - $startTime);


        Log::info('Processamento concluído com ' . $productCount . ' produtos.');
        Log::info('Duração do processo: ' . $this->getDurationProcess() . ' segundos');
        Log::info('Memória inicial: ' .$this->getMemoryInitial());
        Log::info('Memória final: ' . $this->getMemoryFinally());
        Log::info('Pico de uso de memória: ' . $this->getMemoryUsage());
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
    public function execute()
    {
        $this->processLarge();
        return $this;
    }
}
