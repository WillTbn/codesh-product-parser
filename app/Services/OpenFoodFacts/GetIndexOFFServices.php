<?php
namespace App\Services\OpenFoodFacts;

use App\Services\Service;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetIndexOFFServices extends Service
{
    /**
     * content file
     */
    public string|Exception $fileContent;
    /**
     * content file
     */
    public Array $lines;
    /**
     * Api integration  - get datas
     *
     */
    public function conectToApi()
    {
        try{
            // product-1.json.gz
            // product-2.json.gz
            return Http::openfoodfacts()->get('index.txt');
        }catch(Exception $e){
            Log::error('exception'.$e);
            return response()->json([
                'message'=>'erro',
                'exception' => $e
            ]);
        }
    }
    /**
     * set file content - return API openfoodfacts
     */
    public function setFileContent()
    {
        $this->fileContent = $this->conectToApi();
    }
    /**
     * get file content - return API openfoodfacts
     * @return string
     */
    public function getFileContent()
    {
        return $this->fileContent;
    }
    /**
     * set $lines - return content API openfoodfacts line for line
     */
    public function setLines()
    {
        $this->lines = array_filter(explode(PHP_EOL, $this->getFileContent()));
    }
    /**
     * get $lines - return content API openfoodfacts line for line
     *
     */
    public function getLines()
    {
        return $this->lines;
    }

    public function execute():getIndexOFFServices
    {
        return $this;
    }
}
