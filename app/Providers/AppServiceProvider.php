<?php

namespace App\Providers;

use Dotenv\Dotenv;
use App\Exceptions\ApiException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        try {
            $dotenv = Dotenv::createMutable(base_path());
            $dotenv->load();
            $dotenv->required(['SERVER_PORT', 'CLIENT_ORIGIN_URL']);
        } catch (\Exception $ex) {
            throw new ApiException('The required environment variables are missing. Please check the .env file.');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
