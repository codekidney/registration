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


Auth::routes();
Route::get('/', 'HomeController@index');
//Route::get('/', 'Auth\RegisterController@showRegistrationForm');
Route::get('home', 'UserController@show')->name('home');
Route::get('user', 'UserController@show')->name('user_profile');
Route::get('edit', 'UserController@edit')->name('user_edit');
Route::post('update', 'UserController@update')->name('user_update');
Route::prefix('admin')->group(function(){
    Route::get('users','UserController@index')->name('admin_home');
    Route::get('users/last/{days}','UserController@index');
    Route::get('languages','LanguageController@index');
});
