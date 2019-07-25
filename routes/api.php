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

Route::get('/obr-simulada/version/{os}', 'API\ObrSimuladaController@version');
