<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'api', 'as' => 'api.'], function () {
  Route::get('/working-hours/{date?}', 'indexController@getWorkingHours')->name('getWorkingHours');
  Route::post('/appointment-store', 'indexController@appointmentStore')->name('appointmentStore');

  Route::group(['namespace' => 'admin', 'as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('/all', 'indexController@all')->name('all');

    Route::get('/list','indexController@getList')->name('getList');
    Route::get('/today-list','indexController@getTodayList')->name('getTodayList');
    Route::get('/last-list','indexController@getLastList')->name('getLastList');
    Route::get('/waiting-list','indexController@getWaitingList')->name('getWaitingList');
    Route::get('/cancel-list','indexController@getCancelList')->name('getCancelList');

    Route::post('/process', 'indexController@process')->name('process');
  });
});