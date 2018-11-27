<?php

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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/obrsimulada', function () {
    return view('obrsimulada');
})->name('obrsimulada');

Route::get('/programar', 'ProgramController@program')->name('program');
Route::post('/compilar', 'ProgramController@compile')->name('compile');
Route::get('/traduzir', 'ProgramController@translate')->name('translate');
Route::get('/fetchlanguage/{id}', 'ProgramController@language');


Route::get('/linguagens', 'ProgrammingLanguageController@index')->name('languages');

Route::resource('users', 'UserController', ['except' => ['create', 'store']]);
Route::resource('languages', 'ProgrammingLanguageController');
Route::get('/languages/user/current', 'ProgrammingLanguageController@byUser')->name('languages.by-user');
Route::resource('functions', 'FunctionController', ['except' => ['create']]);
Route::get('/functions/create/{language}', 'FunctionController@create')->name('functions.create');
Route::get('/funcoes/linguagem/{language}', 'FunctionController@byLanguage')->name('functions.by-language');

Route::post('/program', 'ProgramController@store');
Route::put('/program/{program}', 'ProgramController@update');
Route::post('/program/{program}/compile_target', 'ProgramController@compileTarget');
Route::get('/program/{program}/send_code', 'ProgramController@sendCode')->name('programs.send-program');
Route::get('/program/{program}/download', 'ProgramController@downloadProgram');
Route::get('/program/{program}/download/jssc', 'ProgramController@downloadJssc');

Route::get('/download/envio/linguagem/{language}', 'ProgramController@downloadSendZip');

Route::get('/classrooms', 'ClassroomController@index')->name('classrooms.index');
Route::get('/classrooms/enrolled', 'ClassroomController@index')->name('classrooms');
Route::get('/coaching', 'ClassroomController@coaching')->name('coaching');
