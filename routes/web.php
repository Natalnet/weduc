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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/programar', 'ProgramController@program')->name('program');
Route::post('/compilar', 'ProgramController@compile')->name('compile');
Route::get('/traduzir', 'ProgramController@translate')->name('translate');
Route::get('/fetchlanguage/{id}', 'ProgramController@language');


Route::get('/linguagens', 'ProgrammingLanguageController@index')->name('languages');

Route::resource('users', 'UserController', ['except' => ['create', 'store']]);
Route::resource('languages', 'ProgrammingLanguageController');
Route::get('/languages/user/current', 'ProgrammingLanguageController@byUser')->name('languages.by-user');
Route::resource('functions', 'FunctionController');
Route::get('/funcoes/linguagem/{language}', 'FunctionController@byLanguage')->name('functions.by-language');

Route::put('/program/{program}', 'ProgramController@update');
Route::get('/program/{program}/compile_target','ProgramController@compileTarget');
Route::get('/program/{program}/send_code','ProgramController@sendCode')->name('programs.send-program');
Route::get('/program/{program}/download', 'ProgramController@downloadProgram');

Route::get('/download/envio/linguagem/{language}', 'ProgramController@downloadSendZip');