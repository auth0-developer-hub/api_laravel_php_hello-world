<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authorize
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        $user = $this->auth->guard('api')->user();

        if (empty($user)) {
            throw new ApiException('Requires authentication', 401);
        }

        $userPermissions = $user->permissions ?? [];

        foreach ($permissions as $permission) {
            if (!in_array($permission, $userPermissions)) {
                throw ApiException::withDetails([
                    'error'=> 'insufficient_permissions',
                    'error_description' => 'Insufficient permissions to access resource',
                    'message' => "Permission denied"
                ], 403);
            }
        }

        return $next($request);
    }
}
