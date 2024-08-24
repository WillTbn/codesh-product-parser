<?php

use App\Console\Commands\OpenFoodFactsImport;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



// rodar em desenvolvimento para teste
Schedule::command(OpenFoodFactsImport::class)->everyMinute();

//rodar em production
// Schedule::command(OpenFoodFactsImport::class)->dailyAt(env('SCJ_IMPORT_PRODUCTS'), '10:00');
