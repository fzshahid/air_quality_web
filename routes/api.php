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
    Route::post('/air-quality-readings', [AirQualityReadingsAPIController::class, 'store'])->name('airQualityReadings.store');
});
Route::group([
], function () {
    Route::post('/subscribe', [WidgetController::class, 'subscribe'])->name('airQualityReadings.subscribe');
    Route::get('/get-widget-data', [WidgetController::class, 'getWidgetData'])->name('getWidgetData');
});
