<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessagesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'messages', 'middleware' => ['insert-metadata']], function () {
    Route::get('public', [MessagesController::class, 'showPublicMessage']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('protected', [MessagesController::class, 'showProtectedMessage']);
        Route::get('admin', [MessagesController::class, 'showAdminMessage']);
    });
});
