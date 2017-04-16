<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::resource('/threads', 'ThreadsController');

Route::post('/threads/{thread}/replies', 'RepliesController@store')->name('replies.store');
