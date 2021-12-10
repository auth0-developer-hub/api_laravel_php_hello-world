<?php

namespace App\Providers;

use Dotenv\Dotenv;
use App\Exceptions\ApiException;
use App\Services\JWTService;
use App\Services\JWTServiceInterface;
use App\Services\MessageService;
use App\Services\MessageServiceInterface;
use GuzzleHttp\Client as GuzzleClient;
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
            $dotenv->required([
                'SERVER_PORT',
                'CLIENT_ORIGIN_URL',
                'AUTH0_AUDIENCE',
                'AUTH0_DOMAIN'
            ]);
        } catch (\Exception $ex) {
            throw new ApiException('The required environment variables are missing. Please check the .env file.');
        }

        $this->app->bind(MessageServiceInterface::class, MessageService::class);
        $this->app->bind(JWTServiceInterface::class, JWTService::class);
        $this->app->singleton('httpClient', function () {
            return new GuzzleClient([]);
        });
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
