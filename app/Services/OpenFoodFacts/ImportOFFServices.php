<?php
namespace App\Services\OpenFoodFacts;

use App\Services\Service;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    public Array $filesName;
    /**
     * URL complet filepath
     */
    public string $filepath;
    /**
     * limit
     */
    public ?int $limit = 100;

    /**
     * set FilesName
     */
    public function setFilesName()
    {
        $this->filesName = $this->files;
    }

    /**
     * get filesName
     * @return array
     */
    public function getFilesName():array
    {
        return $this->filesName;
    }

    public function execute()
    {
        return $this;
    }
}
