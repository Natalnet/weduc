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

Route::get('/languages/', 'API\LanguageController@index');
Route::get('/languages/{language}/functions', 'API\LanguageController@functions');
Route::get('/languages/{language}/download/sending', 'API\LanguageController@downloadSending');

Route::post('/programs/', 'API\ProgramController@store');
Route::get('/programs/user/current', 'API\ProgramController@indexForCurrentUser');
Route::get('/programs/user/current/language/{language}', 'API\ProgramController@indexForCurrentUserAndLanguage');
Route::get('/programs/user/{user}', 'API\ProgramController@indexForUser');
Route::put('/programs/{program}', 'API\ProgramController@update');
Route::delete('/programs/{program}', 'API\ProgramController@destroy');
Route::get('/programs/{program}/compile', 'API\ProgramController@compile');

Route::get('/metrics/compilation-errors', 'API\MetricsController@compilationErrors');
Route::get('/metrics/compilations-per-day', 'API\MetricsController@compilationsPerDay');

Route::get('/classrooms', 'API\ClassroomController@index');
Route::post('/classrooms', 'API\ClassroomController@store');
Route::post('/classrooms/join', 'API\ClassroomController@join');
Route::get('/classrooms/coaching', 'API\ClassroomController@coaching');
Route::get('/classrooms/studying', 'API\ClassroomController@studying');

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

