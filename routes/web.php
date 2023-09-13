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

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/display-students', 'HomeController@display')->name('display');

Route::get('/create-page', 'HomeController@create')->name('create');
Route::post('/create', 'HomeController@store')->name('store');

Route::get('/edit/{student_type}/{id}', 'HomeController@edit')->name('edit');
Route::put('/update/{id}/{student_type}', 'HomeController@update')->name('update');

Route::delete('/delete', 'HomeController@delete')->name('delete');