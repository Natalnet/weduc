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

Route::get('/languages/', 'API\LanguageController@index');
Route::get('/languages/{language}/functions', 'API\LanguageController@functions');

Route::post('/programs/', 'API\ProgramController@store');
Route::get('/programs/user/current', 'API\ProgramController@indexForCurrentUser');
Route::get('/programs/user/current/language/{language}', 'API\ProgramController@indexForCurrentUserAndLanguage');
Route::get('/programs/user/{user}', 'API\ProgramController@indexForUser');
Route::put('/programs/{program}', 'API\ProgramController@update');
Route::get('/programs/{program}/compile', 'API\ProgramController@compile');

Route::get('/metrics/compilation-errors', 'API\MetricsController@compilationErrors');
Route::get('/metrics/compilations-per-day', 'API\MetricsController@compilationsPerDay');
