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

Route::get('/documents', 'GuestController@getPublicDocuments');
Route::get('/documents/download/{id}', 'GuestController@getDownloadDocuments');

// require specific routes Here
require __DIR__ . '/Admin/AdminRoutes.php';
require __DIR__ . '/User/UserRoutes.php';

Route::get('/test', function () {
  $start_date = (new Carbon(date('Y-m-d') . App\Settings::first()->crane_start_time));

  for ($i=1; $i <= 16 ; $i++) {
    $current_time = $start_date->addMinutes(30);
    foreach (App\CraneReservation::all() as $reservation) {
      if (Carbon::parse($reservation->time)->format('H:i') == $current_time->format('H:i')) {
        echo "already taken <br>";
      } else {
        echo $current_time->format('H:i') . '<br>';
      }
      $start_date = $current_time;
    }
  }
  return;
});
