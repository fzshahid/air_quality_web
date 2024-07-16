<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\WidgetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WidgetController::class, 'index'])->name('widget.index');
Route::get('/admin', function () {
    return redirect(route('brackets/admin-auth::admin/login'));
});


Route::prefix('dashboard')->namespace('App\Http\Controllers\Admin')->name('dashboard/')->group(static function () {
    Route::get('/',                                             [DashboardController::class, 'index'])->name('index')->middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin']);
    Route::get('/line-chart-temperature',                                       [DashboardController::class, 'temperatureLineChart'])->name('temperatureLineChart');
    Route::get('/line-chart-pm',                                       [DashboardController::class, 'lineChartPM'])->name('lineChartPM');
    Route::get('/line-chart-pm-1',                                       [DashboardController::class, 'lineChartPM1'])->name('lineChartPM1');
    Route::get('/line-chart-pm-2-5',                                       [DashboardController::class, 'lineChartPm25'])->name('lineChartPm25');
    Route::get('/line-chart-pm-4',                                       [DashboardController::class, 'lineChartPM4'])->name('lineChartPM4');
    Route::get('/line-chart-pm-10',                                       [DashboardController::class, 'lineChartPm10'])->name('lineChartPm10');
    Route::get('/line-chart-humidity',                                       [DashboardController::class, 'lineChartHumidity'])->name('lineChartHumidity');
    Route::get('/line-chart-tvoc',                                       [DashboardController::class, 'lineChartTvoc'])->name('lineChartTvoc');
    Route::get('/line-chart-co-2',                                       [DashboardController::class, 'lineChartCo2'])->name('lineChartCo2');
});
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {

    
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('air-quality-readings')->name('air-quality-readings/')->group(static function() {
            Route::get('/',                                             'AirQualityReadingsController@index')->name('index');
            Route::get('/create',                                       'AirQualityReadingsController@create')->name('create');
            Route::post('/',                                            'AirQualityReadingsController@store')->name('store');
            Route::get('/{airQualityReading}/edit',                     'AirQualityReadingsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AirQualityReadingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{airQualityReading}',                         'AirQualityReadingsController@update')->name('update');
            Route::delete('/{airQualityReading}',                       'AirQualityReadingsController@destroy')->name('destroy');
        });
    });
});


Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('subscribers')->name('subscribers/')->group(static function() {
            Route::get('/',                                             'SubscribersController@index')->name('index');
            Route::get('/create',                                       'SubscribersController@create')->name('create');
            Route::post('/',                                            'SubscribersController@store')->name('store');
            Route::get('/{subscriber}/edit',                            'SubscribersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SubscribersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{subscriber}',                                'SubscribersController@update')->name('update');
            Route::delete('/{subscriber}',                              'SubscribersController@destroy')->name('destroy');
        });
    });
});