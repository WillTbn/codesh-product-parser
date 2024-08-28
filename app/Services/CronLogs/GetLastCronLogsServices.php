<?php
namespace App\Services\CronLogs;

use App\DTOs\CronLogsDTO;
use App\Models\CronLogs;
use App\Repository\Eloquent\CronLogsRepositoryEloquent;
use Exception;
use App\Services\Service;
use DateTime;
use Illuminate\Support\Facades\Log;

class GetLastCronLogsServices extends Service
{
    private CronLogsRepositoryEloquent $cronLogsRepositoryEloquent;
    protected ?CronLogs $cronLog;
    /**
     * Service constructor
     *
     */
    public function __construct(
        CronLogsRepositoryEloquent $cronLogsRepositoryEloquent
    )
    {
        $this->cronLogsRepositoryEloquent = $cronLogsRepositoryEloquent;
    }
    public function setCronLog()
    {
        $this->cronLog = $this->cronLogsRepositoryEloquent->getCronLogLast();
    }
    public function geCronLog():?CronLogs
    {
        return $this->cronLog;
    }
    public function execute()
    {
        $this->setCronLog();
        $this;
    }
}
