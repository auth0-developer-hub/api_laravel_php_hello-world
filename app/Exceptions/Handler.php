<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $exception) {
            return $this->apiError('Not Found', 404);
        });

        $this->renderable(function (ApiException $exception) {
            return $this->apiError($exception->getMessage(), 500);
        });

        $this->renderable(function (Throwable $exception) {
            dd($exception->getMessage());
            return $this->apiError('Internal Server Error', 500);
        });
    }

    protected function apiError($message, $code)
    {
        return response()->json(['message' => $message], $code);
    }
}
