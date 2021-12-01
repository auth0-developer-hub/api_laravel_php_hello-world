<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MessageController;

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

Route::group(['prefix' => 'messages'], function () {
    Route::get('public', [MessageController::class, 'getPublicMessage']);
    Route::get('protected', [MessageController::class, 'getProtectedMessage']);
    Route::get('admin', [MessageController::class, 'getAdminMessage']);
});
