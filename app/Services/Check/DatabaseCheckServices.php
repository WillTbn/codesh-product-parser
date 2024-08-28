<?php
namespace App\Services\Check;

use Exception;
use App\Services\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseCheckServices extends Service
{
    protected string $read = 'OK';
    protected string $database = 'OK';
     /**
     * verify connection from read
     */
    public function setRead()
    {
        try {
            DB::connection()->getPdo();
        } catch (Exception $e) {
            Log::error('Database read connection failed: ' . $e->getMessage());
            $this->read = 'Failed';
        }
    }

    public function getRead()
    {
        return $this->read;
    }
     /**
     * verify connection from write
     */
    public function setDatabase()
    {
        try {
            DB::transaction(function () {
                DB::table('users')->insert([
                    'name' => 'Test User',
                    'email'=>'teste@teste.com.br',
                    'password' =>'teste'
                ]);
                throw new Exception('Rollback Test');
            });
        } catch (Exception $e) {
            if ($e->getMessage() !== 'Rollback Test') {
                Log::error('Database write connection failed: ' . $e->getMessage());
                $this->database = 'Failed';
            }
        }
    }
    public function getDatabase(){
        return $this->database;
    }
    /**
     * execute verifications
     */
    public function execute():DatabaseCheckServices
    {

        $this->setDatabase();
        $this->setRead();

        return $this;
    }
}
