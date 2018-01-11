<?php

Route::group(['middleware' => ['auth'], 'prefix' => 'user'], function () {
  Route::get('/dashboard', 'UserController@getDashboard');

  Route::post('/dashboard/plan', 'UserController@postPlan');
  Route::post('/dashboard/inhabour', 'UserController@postInHabour');
  Route::get('/dashboard/reservation/available/{date}', 'UserController@postGetReservationData');

  Route::get('/profile', 'UserController@getProfile');
  Route::post('/profile', 'UserController@postProfile');

  Route::get('/invoice/pdf/{id}', 'UserController@getInvoicePdf');


});
