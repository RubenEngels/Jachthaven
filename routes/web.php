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

Route::get('/', 'GuestController@getIndex');
Route::post('/', 'GuestController@postNewsLetter');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/contact', 'GuestController@getContact');
Route::post('/contact', 'GuestController@postContact');

// require specific routes Here
require __DIR__ . '/Admin/AdminRoutes.php';
require __DIR__ . '/User/UserRoutes.php';
