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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users/', 'API\UserController@index');

Route::prefix('/languages')->middleware('throttle:60,1')->namespace('API')->group(function () {
    Route::get('/', 'LanguageController@index');
    Route::get('/{language}/functions', 'LanguageController@functions');
    Route::get('/{language}/download/sending', 'LanguageController@downloadSending');
});

Route::prefix('/programs')->namespace('API')->group(function () {
    Route::post('/', 'ProgramController@store');
    Route::get('/user/current', 'ProgramController@indexForCurrentUser');
    Route::get('/user/current/language/{language}', 'ProgramController@indexForCurrentUserAndLanguage');
    Route::get('/user/{user}', 'ProgramController@indexForUser');
    Route::put('/{program}', 'ProgramController@update');
    Route::delete('/{program}', 'ProgramController@destroy');
    Route::get('/{program}/compile', 'ProgramController@compile');
    Route::get('/{program}/download/sender', 'ProgramController@downloadCodeSender');
});

Route::get('/metrics/compilation-errors', 'API\MetricsController@compilationErrors');
Route::get('/metrics/compilations-per-day', 'API\MetricsController@compilationsPerDay');

Route::prefix('/classrooms')->namespace('API')->group(function () {
    Route::get('/', 'ClassroomController@index');
    Route::post('/', 'ClassroomController@store');
    Route::post('/join', 'ClassroomController@join');
    Route::get('/coaching', 'ClassroomController@coaching');
    Route::get('/studying', 'ClassroomController@studying');
});

Route::prefix('/obr-simulada')->namespace('API')->group(function () {
    Route::get('/version/{os}', 'ObrSimuladaController@version');

    Route::prefix('/arenas')->middleware('auth:api')->group(function () {
        Route::get('/', 'ArenaController@index');
        Route::post('/', 'ArenaController@store');
        Route::get('/{arena}', 'ArenaController@show');
        Route::put('/{arena}', 'ArenaController@update');
        Route::delete('/{arena}', 'ArenaController@destroy');

        Route::prefix('/{arena}/usages')->group(function () {
            Route::get('/', 'ArenaUsageController@arenaIndex');
            Route::post('/', 'ArenaUsageController@store');
            Route::get('/average', 'ArenaUsageController@average');
        });
    });
});

