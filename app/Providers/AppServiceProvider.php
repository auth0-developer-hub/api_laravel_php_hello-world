<?php

namespace App\Providers;

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
        if (isset($_ENV['VALIDATE_ENV']) && !$_ENV['VALIDATE_ENV']) {
            return;
        }

        $required = ['SERVER_PORT', 'CLIENT_ORIGIN_URL'];
        foreach ($required as $name) {
            $value = env($name);
            if (empty($value)) {
                throw new ApiException('The required environment variables are missing. Please check the .env file.');
            }
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
