<?php
namespace App\Services\CronLogs;

use App\DTOs\CronLogsDTO;
use App\Repository\Eloquent\CronLogsRepositoryEloquent;
use Exception;
use App\Services\Service;
use DateTime;
use Illuminate\Support\Facades\Log;

class CreateCronLogsServices extends Service
{
    public string|float $startTime;
    public string|float $endTime;
    public int $initialMemory;
    public int $usageMemory;
    public function setStartTime()
    {
        $this->startTime = microtime(true);
    }
    public function setEndTime()
    {
        $this->endTime = microtime(true);
    }
    public function setInitialMemory()
    {
        $this->initialMemory = memory_get_usage(true);
    }
    public function setUsageMemory()
    {
        $this->usageMemory = memory_get_peak_usage(true);
    }
    public function getExecuteTime():float
    {
        return $this->endTime - $this->startTime;
    }
    public function getUsageMemory():string
    {
        return $this->formatBytes($this->usageMemory);
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
        try{
            $dto = new CronLogsDTO(new DateTime(),$this->getExecuteTime(),  $this->getUsageMemory());
            $cronRepository = new CronLogsRepositoryEloquent();
            $cronRepository->save($dto);
            return $this;
        }catch(Exception $e){
            Log::error('Erro : '.json_encode($e));
        }
    }
}
