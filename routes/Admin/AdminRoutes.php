<?php

Route::group(['middleware' => ['admin','auth'], 'prefix' => 'admin'], function () {
  Route::get('settings','AdminController@getSettings');
  Route::post('settings', 'AdminController@postSettings');

  Route::get('events', 'AdminController@getEvents');
  Route::post('events', 'AdminController@postEvents');
  Route::get('/events/delete/{id}', 'AdminController@getDeleteEvents');

  Route::get('documents', 'AdminController@getDocuments');
  Route::post('documents', 'AdminController@postEditDocument');
  Route::post('documents/new', 'AdminController@postNewDocument');
  Route::get('documents/delete/{id}', 'AdminController@getDeleteDocument');
  Route::get('documents/download/{id}', 'AdminController@getDownloadDocument');

  Route::get('notifications', 'AdminDashboardController@getNotifications');

  Route::get('dashboard', 'AdminDashboardController@getDashboard');
});
