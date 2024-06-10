<?php

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

Route::get('/', function () {
    return view('welcome');
});


/* Auto-generated admin routes */
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

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
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

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('ccs811-readings')->name('ccs811-readings/')->group(static function() {
            Route::get('/',                                             'Ccs811ReadingsController@index')->name('index');
            Route::get('/create',                                       'Ccs811ReadingsController@create')->name('create');
            Route::post('/',                                            'Ccs811ReadingsController@store')->name('store');
            Route::get('/{ccs811Reading}/edit',                         'Ccs811ReadingsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'Ccs811ReadingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{ccs811Reading}',                             'Ccs811ReadingsController@update')->name('update');
            Route::delete('/{ccs811Reading}',                           'Ccs811ReadingsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('scd41-readings')->name('scd41-readings/')->group(static function() {
            Route::get('/',                                             'Scd41ReadingsController@index')->name('index');
            Route::get('/create',                                       'Scd41ReadingsController@create')->name('create');
            Route::post('/',                                            'Scd41ReadingsController@store')->name('store');
            Route::get('/{scd41Reading}/edit',                          'Scd41ReadingsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'Scd41ReadingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{scd41Reading}',                              'Scd41ReadingsController@update')->name('update');
            Route::delete('/{scd41Reading}',                            'Scd41ReadingsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('Admin')->name('admin/')->group(static function() {
        Route::prefix('sps30-readings')->name('sps30-readings/')->group(static function() {
            Route::get('/',                                             'Sps30ReadingsController@index')->name('index');
            Route::get('/create',                                       'Sps30ReadingsController@create')->name('create');
            Route::post('/',                                            'Sps30ReadingsController@store')->name('store');
            Route::get('/{sps30Reading}/edit',                          'Sps30ReadingsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'Sps30ReadingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{sps30Reading}',                              'Sps30ReadingsController@update')->name('update');
            Route::delete('/{sps30Reading}',                            'Sps30ReadingsController@destroy')->name('destroy');
        });
    });
});