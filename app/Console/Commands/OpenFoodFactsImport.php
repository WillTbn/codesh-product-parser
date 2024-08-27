<?php

namespace App\Console\Commands;

use App\Services\CronLogs\CreateCronLogsServices;
use App\Services\OpenFoodFacts\GetIndexOFFServices;
use App\Services\OpenFoodFacts\ImportOFFServices;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenFoodFactsImport extends Command
{

    private GetIndexOFFServices $getIndexOFFServices;
    private CreateCronLogsServices $createCronLogsServices;
    public function __construct(
        GetIndexOFFServices $getIndexOFFServices,
        CreateCronLogsServices $createCronLogsServices
    )
    {
        parent::__construct();

        $this->getIndexOFFServices = $getIndexOFFServices;
        $this->getIndexOFFServices->setFileContent();
        $this->getIndexOFFServices->setLines();

        $this->createCronLogsServices = $createCronLogsServices;
        $this->createCronLogsServices->setStartTime();
        $this->createCronLogsServices->setInitialMemory();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'open-food-facts:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pegando dados da API Open Food Facts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try{


            $getindex = $this->getIndexOFFServices->execute();

             foreach($getindex->lines as $line){
                $importOFFServices = new ImportOFFServices();
                $importOFFServices->setFileName($line);
                $importOFFServices->execute();
            }

            $this->createCronLogsServices->setEndTime();
            $this->createCronLogsServices->setUsageMemory();
            $this->createCronLogsServices->execute();

            Log::info('Finalizado todo processo no cron');
            // Log::info(json_encode($importOFFServices->getProcessedRecords()));
        }catch(Exception $e)
        {
            $this->error('Error:'.$e);
        }
    }
}
