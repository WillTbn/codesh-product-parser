<?php

namespace App\Http\Controllers;

use App\Services\Check\DatabaseCheckServices;
use App\Services\CronLogs\GetLastCronLogsServices;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    private DatabaseCheckServices $databaseCheckServices;
    private GetLastCronLogsServices $getLastCronLogsServices;

    public function __construct(
        DatabaseCheckServices $databaseCheckServices,
        GetLastCronLogsServices $getLastCronLogsServices

    )
    {
        $this->databaseCheckServices = $databaseCheckServices;
        $this->getLastCronLogsServices = $getLastCronLogsServices;
    }
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $this->databaseCheckServices->execute();
        $this->getLastCronLogsServices->execute();
        return new JsonResponse(
            [
                'message' =>  'Sejá bem vindo!',
                'database'=>[
                    'read' => $this->databaseCheckServices->getRead(),
                    'status' => $this->databaseCheckServices->getDatabase(),
                    'write' => $this->databaseCheckServices->getDatabase(),
                ],
                'cron' => $this->getLastCronLogsServices->geCronLog()
            ],
            200
        );
    }
}
