<?php

use App\Http\Controllers\Admin\WidgetController;
use App\Http\Controllers\API\AirQualityReadingsAPIController;
use Illuminate\Http\Request;
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


Route::group([
    // 'middleware' => 'auth:api',
], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/subscribe', [WidgetController::class, 'subscribe'])->name('airQualityReadings.subscribe');
    Route::post('/air-quality-readings', [AirQualityReadingsAPIController::class, 'store'])->name('airQualityReadings.store');
    Route::post('/store-ccs811-readings', [AirQualityReadingsAPIController::class, 'storeCcs811'])->name('airQualityReadings.storeCcs811');
    Route::post('/store-scd41-readings', [AirQualityReadingsAPIController::class, 'storeScd41'])->name('airQualityReadings.storeScd41');
    Route::post('/store-sps30-readings', [AirQualityReadingsAPIController::class, 'storeSps30'])->name('airQualityReadings.storeSps30');
});
