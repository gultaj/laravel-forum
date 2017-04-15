<?php

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/threads', 'ThreadsController@index')->name('threads');
Route::get('/threads/{thread}', 'ThreadsController@show')->name('threads.show');
Route::post('/threads/{thread}/replies', 'RepliesController@store')->name('replies.store');
