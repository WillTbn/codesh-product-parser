<?php
namespace App\Repository\Eloquent;

use App\DTOs\CronLogsDTO;
use App\Models\CronLogs;
use App\Repository\CronLogsRepository;
use Illuminate\Database\Eloquent\Collection;

class CronLogsRepositoryEloquent implements CronLogsRepository
{
    public function all():int|Collection
    {
        $product = CronLogs::all();
        return $product;
    }
    public function save(CronLogsDTO $cron_logs):void
    {
        CronLogs::create([
            'last_run'=> $cron_logs->getLastRun(),
            'execute_time'=> $cron_logs->getExecutionTime(),
            'usage_memory' =>  $cron_logs->getUsageMemory(),
        ]);
    }
}
