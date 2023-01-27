<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowComedianController;
use App\Http\Controllers\GetComedianByIdController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ListAttractionsByComedianNameController;
use App\Http\Controllers\ListAttractionsController;
use App\Http\Controllers\ListAttractionsByComedianController;
use App\Http\Controllers\ListAttractionsByLocationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('health', [HealthController::class, 'healthCheck']);

    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('jwt.verify')->group(function() {
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::post('/user/follow',  [FollowComedianController::class, 'handle']);
    });



    Route::get('/comedian/{comedianId}',  [GetComedianByIdController::class, 'handle']);


    Route::get('attractions/location',  [ListAttractionsByLocationController::class, 'handle']);
    Route::get('attractions/{place}',  [ListAttractionsController::class, 'handle']);
    Route::get('attractions/comedian/{comedianId}',  [ListAttractionsByComedianController::class, 'handle']);
    Route::get('attractions/comedian/name/{comedianName}',  [ListAttractionsByComedianNameController::class, 'handle']);

});
