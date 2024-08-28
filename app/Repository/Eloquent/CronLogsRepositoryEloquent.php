<?php
namespace App\Repository\Eloquent;

use App\DTOs\CronLogsDTO;
use App\Models\CronLog;
use App\Repository\CronLogsRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CronLogsRepositoryEloquent implements CronLogsRepository
{
    public function all():int|Collection
    {
        $product = CronLog::all();
        return $product;
    }
    public function save(CronLogsDTO $cron_logs):void
    {
        CronLog::create([
            'last_run'=> $cron_logs->getLastRun(),
            'execute_time'=> $cron_logs->getExecutionTime(),
            'usage_memory' =>  $cron_logs->getUsageMemory(),
        ]);
    }
    public function getCronLogLast():?CronLog
    {
        $cron = CronLog::latest()->first();
        return $cron;
    }
}
