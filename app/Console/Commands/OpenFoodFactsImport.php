<?php

namespace App\Console\Commands;

use App\Services\OpenFoodFacts\GetIndexOFFServices;
use App\Services\OpenFoodFacts\ImportOFFServices;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenFoodFactsImport extends Command
{

    private GetIndexOFFServices $getIndexOFFServices;
    public function __construct(
        GetIndexOFFServices $getIndexOFFServices
    )
    {
        parent::__construct();

        $this->getIndexOFFServices = $getIndexOFFServices;
        $this->getIndexOFFServices->setFileContent();
        $this->getIndexOFFServices->setLines();
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

            // foreach($getindex->lines as $line){

            // }
            $importOFFServices = new ImportOFFServices();
            $importOFFServices->setFileName($getindex->lines[0]);
            $importOFFServices->execute();
            Log::info('ESTOU AQUI2!!!');
            // Log::info(json_encode($importOFFServices->getProcessedRecords()));
        }catch(Exception $e)
        {
            $this->error('Error:'.$e);
        }
    }
}
