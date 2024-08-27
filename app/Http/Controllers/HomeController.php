<?php

namespace App\Http\Controllers;

use App\Repository\Eloquent\CronLogsRepositoryEloquent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function home()
    {
        $cronLogsRepository = new CronLogsRepositoryEloquent();

        return new JsonResponse(
            ['message' =>  'Sejá bem vindo!',  'crons' => $cronLogsRepository->all()],
            200
        );
    }
}
