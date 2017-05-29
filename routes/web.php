<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::post('/threads/{thread}/subscriptions', 'SubscribesController@storeThread')->name('threads.subscribe');
Route::delete('/threads/{thread}/subscriptions', 'SubscribesController@destroyThread')->name('threads.unsubscribe');

Route::get('/threads/{thread}/replies', 'RepliesController@index')->name('replies.index');
Route::post('/threads/{thread}/replies', 'RepliesController@store')->name('replies.store');
Route::patch('/replies/{reply}', 'RepliesController@update')->name('replies.update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('replies.favorites');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('replies.unfavorites');


Route::resource('/threads', 'ThreadsController', ['except' => ['show', 'index']]);
Route::get('/threads/{channel?}', 'ThreadsController@index')->name('threads.index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');

Route::get('/profiles/{user}', 'UsersController@show')->name('users.show');
Route::get('/profiles/{user}/notifications', 'NotificationsController@index')->name('users.notifications');
Route::delete('/profiles/{user}/notifications/{notification}', 'NotificationsController@destroy')->name('users.notifications.destroy');
