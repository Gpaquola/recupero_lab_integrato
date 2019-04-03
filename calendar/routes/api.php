<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::prefix('event')->group(function () {

    Route::post('create', 'EventController@createEvent');
    Route::get('{get_by}', 'EventController@getEventBy');

    Route::prefix('year/{year}')->group(function () {
        Route::get('/', 'EventController@getYear');
        Route::get('week/{week}', 'EventController@getWeek');

        Route::prefix('month/{month}')->group(function () {
            Route::get('/', 'EventController@getMonth');
            Route::get('day/{day}', 'EventController@getDay');
        });
    });

    Route::post('modify/{id}', 'EventController@modEvent');

    Route::prefix('drop')->group(function () {
        Route::delete('{id}', 'EventController@deleteEvent');

        Route::prefix('year/{year}')->group(function () {
            Route::delete('/', 'EventController@deleteBy');
            Route::delete('month/{month}', 'EventController@deleteBy');
            Route::delete('month/{month}/day/{day}', 'EventController@deleteBy');
        });
    });
});
