<?php

namespace App\Providers;

use App\Services\JWTService;
use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Auth0::class, function () {
            $config = array_merge(config('auth0'), [
                'httpClient' => $this->app->make('httpClient'),
                'strategy' => 'api'
            ]);

            $configuration = new SdkConfiguration($config);

            return new Auth0($configuration);
        });
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot(JWTService $jwtService)
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function (Request $request) use ($jwtService) {
            $bearerToken = $jwtService->extractBearerTokenFromRequest($request);
            $data = $jwtService->decodeBearerToken($bearerToken);

            return new GenericUser($data);
        });
    }
}
