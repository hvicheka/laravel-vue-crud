<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/student/create','StudentController@saveStudent');
Route::get('/student','StudentController@index');
Route::get('/student/edit/{id}','StudentController@editStudent');
Route::put('/student/update','StudentController@updateStudent');
Route::delete('/student/delete/{id}','StudentController@deleteStudent');
