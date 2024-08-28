<?php

namespace App\Repository;

use App\DTOs\CronLogsDTO;
use App\Models\CronLog;
use Illuminate\Database\Eloquent\Collection;

interface CronLogsRepository
{
    public function all():int|Collection;
    public function getCronLogLast():?CronLog;
    public function save(CronLogsDTO $cron_logs):void;
    // public function delete(int $cron):void;
}
