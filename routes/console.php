<?php

use App\Console\Commands\OpenFoodFactsImport;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



// rodar em desenvolvimento para teste
// Schedule::command(OpenFoodFactsImport::class)->everyMinute()->emailOutputOnFailure(env('ADMIN_EMAIL'));

//rodar em production
Schedule::command(OpenFoodFactsImport::class)
    ->dailyAt(env('SCJ_IMPORT_PRODUCTS'), '10:00')
    ->emailOutputOnFailure(env('ADMIN_EMAIL'), 'testefail@cron.com');
