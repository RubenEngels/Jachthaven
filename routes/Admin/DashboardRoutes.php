<?php

Route::group(['middleware' => ['admin','auth'], 'prefix' => 'admin'], function () {
  Route::get('dashboard', 'AdminController@getDashboard');
  
  Route::get('settings','AdminController@getSettings');
  Route::post('settings', 'AdminController@postSettings');
});
