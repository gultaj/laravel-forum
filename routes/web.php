<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('/threads', 'ThreadsController', ['except' => ['show', 'index']]);
Route::get('/threads/{channel?}', 'ThreadsController@index')->name('threads.index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');

Route::post('/threads/{thread}/replies', 'RepliesController@store')->name('replies.store');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('replies.favorites');
