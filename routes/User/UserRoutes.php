<?php

Route::group(['middleware' => ['auth'], 'prefix' => 'user'], function () {
  Route::get('/profile', 'UserController@getProfile');
  Route::post('/profile', 'UserController@postProfile');

  Route::post('/profile/photo', 'UserController@postPhoto');
});
