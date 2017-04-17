<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');

Route::resource('/threads', 'ThreadsController', ['except' => 'show']);

Route::post('/threads/{thread}/replies', 'RepliesController@store')->name('replies.store');
