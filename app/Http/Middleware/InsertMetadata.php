<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InsertMetadata
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse && $response->isOk()) {
            $response->setData($this->insertMetadata($response->getData(true)));
        }

        return $response;
    }

    private function insertMetadata($data): array
    {
        return array_merge(
            $data,
            [
                'metadata' => [
                    'api' => config('app.api'),
                    'branch' => config('app.branch'),
                ]
            ]
        );
    }
}
