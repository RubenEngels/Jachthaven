<?php
use Carbon\Carbon;
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
Route::get('/start', 'GuestController@getHome');
Route::post('/', 'GuestController@postNewsLetter');

Auth::routes();

Route::get('/home', function () {
  return redirect('/user/dashboard');
});

Route::get('/contact', 'GuestController@getContact');
Route::post('/contact', 'GuestController@postContact');

Route::get('/agenda', 'GuestController@getAgenda');
Route::post('/event/rsvp', 'GuestController@postRsvp');

Route::get('/documents', 'GuestController@getPublicDocuments');
Route::get('/documents/download/{id}', 'GuestController@getDownloadDocuments');

// require specific routes Here
require __DIR__ . '/Admin/AdminRoutes.php';
require __DIR__ . '/User/UserRoutes.php';
