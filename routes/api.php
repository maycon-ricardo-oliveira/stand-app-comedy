<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowComedianController;
use App\Http\Controllers\GetComedianByIdController;
use App\Http\Controllers\GetPlaceByIdController;
use App\Http\Controllers\GetUserProfileByIdController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ListAttractionsByComedianNameController;
use App\Http\Controllers\ListAttractionsByPlaceController;
use App\Http\Controllers\ListAttractionsByComedianController;
use App\Http\Controllers\ListAttractionsByLocationController;
use App\Http\Controllers\RegisterAttractionController;
use App\Http\Controllers\RegisterPlaceController;
use App\Http\Controllers\UnFollowComedianController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('health', [HealthController::class, 'healthCheck']);

    Route::post('login', [AuthController::class, 'login']);
    Route::post('/user/register',  [UnFollowComedianController::class, 'handle']);

    Route::middleware('jwt.verify')->group(function() {
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::post('/user/follow',  [FollowComedianController::class, 'handle']);
        Route::post('/user/unfollow',  [UnFollowComedianController::class, 'handle']);
        Route::get('/user/{userId}',  [GetUserProfileByIdController::class, 'handle']);
    });

    Route::get('/comedian/{comedianId}',  [GetComedianByIdController::class, 'handle']);

    Route::get('attractions/location',  [ListAttractionsByLocationController::class, 'handle']);
    Route::get('attractions/{place}',  [ListAttractionsByPlaceController::class, 'handle']);
    Route::get('attractions/comedian/{comedianId}',  [ListAttractionsByComedianController::class, 'handle']);
    Route::get('attractions/comedian/name/{comedianName}',  [ListAttractionsByComedianNameController::class, 'handle']);

    Route::post('attractions',  [RegisterAttractionController::class, 'handle']);

    Route::post('places',  [RegisterPlaceController::class, 'handle']);
    Route::post('places/{placeId}',  [GetPlaceByIdController::class, 'handle']);

});
