<?php

namespace App\Providers;

use App\Repository\CronLogsRepository;
use App\Repository\Eloquent\CronLogsRepositoryEloquent;
use App\Repository\ProductRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use APP\Repository\Eloquent\ProductRepositoryEloquent;
use App\Repository\Eloquent\UserRepositoryEloquent;
use App\Repository\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ProductRepository::class, ProductRepositoryEloquent::class);
        $this->app->bind(CronLogsRepository::class, CronLogsRepositoryEloquent::class);
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        Http::macro('openfoodfacts', function(){
            return Http::acceptJson()->baseUrl(config('openfoodfacts.url'));
        });
    }
}
