<?php

Route::group(['middleware' => ['admin','auth'], 'prefix' => 'admin'], function () {
  Route::get('settings','AdminController@getSettings');
  Route::post('settings', 'AdminController@postSettings');
    Route::post('/settings/layout', 'AdminController@postEditLayout');

  Route::get('events', 'AdminController@getEvents');
  Route::post('events', 'AdminController@postEvents');
  Route::get('/events/delete/{id}', 'AdminController@getDeleteEvents');

  Route::get('documents', 'AdminController@getDocuments');
  Route::post('documents', 'AdminController@postEditDocument');
  Route::post('documents/new', 'AdminController@postNewDocument');
  Route::get('documents/delete/{id}', 'AdminController@getDeleteDocument');
  Route::get('documents/download/{id}', 'AdminController@getDownloadDocument');

  Route::get('/notifications/delete/{id}', 'AdminDashboardController@getDeleteNotifications');
  Route::post('notifications', 'AdminDashboardController@postNotifications');

  Route::get('/dashboard/mail/delete/{id}', 'AdminDashboardController@getMailDelete');

  Route::post('/dashboard/newsletter', 'AdminDashboardController@postNewsletter');
  Route::get('/dashboard/newsletter/delete/{id}', 'AdminDashboardController@getDeleteNewsletter');

  Route::post('/dashboard/newsletter/send', 'AdminDashboardController@sendMail');

  Route::get('dashboard', 'AdminDashboardController@getDashboard');

  Route::post('/dashboard/credit/invoice/{id}', 'AdminDashboardController@postCreditInvoice');
  Route::get('/invoice/delete/{id}', 'AdminDashboardController@getDeleteInvoice');
  Route::post('/dashboard/invoice/new', 'AdminDashboardController@postNewInvoice');
  Route::get('/dashboard/invoice/export', 'AdminDashboardController@exportInvoices');
  Route::get('/invoice/setAsPayed/{id}/{date}', 'AdminDashboardController@getSetAsPayed');

  Route::post('/invoice/product/change/{id}', 'AdminController@postChangeDefaultInvoiceProduct');
  Route::post('/settings/invoice/products/new', 'AdminController@postNewInvoiceProduct');
  Route::get('/invoice/product/delete/{id}', 'AdminController@getDeleteDefaultInvoiceProduct');

  Route::post('dashboard/invoice/new/get', 'AdminDashboardController@postGetDefaultInvoiceProduct');

  Route::get('/boat/create', 'AdminController@getCreateBoat');
  Route::post('/boat/create', 'AdminController@postCreateBoat');
  Route::get('boat/delete/{id}', 'AdminController@getDeleteBoat');
  Route::post('boat/edit/{id}', 'AdminController@postEditBoat');

  Route::get('/dashboard/export/crane', 'AdminDashboardController@getExportCrane');

  Route::get('/users', 'AdminController@getUsers');
  Route::post('/users', 'AdminController@postEditUsers');
  Route::get('/users/delete/{id}', 'AdminController@getDeleteUser');

  Route::get('/habour/overview', 'HabourController@getHabourOverview');
  Route::post('/habour/assign/box', 'HabourController@postAssignBox');
  Route::post('/habour/assign/walplaats', 'HabourController@postAssignWalplaats');
  Route::get('/habour/clearfortransfer/{id}', 'HabourController@getClearForTransfer');
  Route::post('/habour/rent', 'HabourController@postRentBox');
  Route::get('/habour/rent/relase/{id}', 'HabourController@getReleaseRent');

  Route::get('/stats', 'AdminDashboardController@getStats');
});
