<?php

use App\Http\Controllers\GetComedianByIdController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ListAttractionsByComedianNameController;
use App\Http\Controllers\ListAttractionsController;
use App\Http\Controllers\ListAttractionsByComedianController;
use App\Http\Controllers\ListAttractionsByLocationController;
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
    Route::get('health', [HealthController::class, 'healthCheck']);

    Route::get('attractions/location',  [ListAttractionsByLocationController::class, 'handle']);
    Route::get('attractions/{place}',  [ListAttractionsController::class, 'handle']);
    Route::get('attractions/comedian/{comedianId}',  [ListAttractionsByComedianController::class, 'handle']);
    Route::get('attractions/comedian/name/{comedianName}',  [ListAttractionsByComedianNameController::class, 'handle']);

    Route::get('comedian/{comedianId}',  [GetComedianByIdController::class, 'handle']);

});
