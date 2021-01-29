<?php

use Illuminate\Support\Facades\Artisan;
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

Route::get('/', 'front\indexController@index');

Route::group(['prefix' => 'cron'], function () {
  Route::get('/reminder', function () {
    Artisan::call('Reminder:Start');
  });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
  Route::get('/', 'indexController@index')->name('index');
  Route::get('/working', 'indexController@working')->name('working');
});
