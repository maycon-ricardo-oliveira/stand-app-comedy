<?php

use App\Http\Controllers\ListAttractionController;
use Illuminate\Support\Facades\Route;

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


Route::prefix('v1')->group(function () {
    Route::get('/health', ['uses' => 'HealthController@healthCheck']);
    Route::get('attractions/{place}',  [ListAttractionController::class, 'handle']);

});
