<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

Route::resource('continent','ContinentController');
Route::resource('agent','AgentController');
Route::resource('quickcode','QuickcodeController');
Route::resource('blogs','BlogsController');
Route::resource('commodities','CommoditiesController');
Route::get('schedule/{dest}','ScheduleController@searchSchedule');
Route::get('schedule/{dest}/{loading}','ScheduleController@otherSchedule');
Route::get('advertisement/news','AdvertisementController@news');
Route::get('advertisement/promotions','AdvertisementController@promotions');
Route::get('advertisement/detail/{id}','AdvertisementController@detail');
Route::get('advertisement/home','AdvertisementController@home');