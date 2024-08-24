<?php

namespace App\Providers;

use App\Repository\ProductReposity;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Reposity\Eloquent\ProductReposityEloquent;

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
        $this->app->bind(ProductReposity::class, ProductReposityEloquent::class);
        Http::macro('openfoodfacts', function(){
            return Http::acceptJson()->baseUrl(config('openfoodfacts.url'));
        });
    }
}
