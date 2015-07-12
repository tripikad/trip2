<?php

// Frontpage

get('/', 'FrontpageController@index');

// Legacy content
/*
get('content/{part3}/{part2}/{part1}.html{suffix?}', 'ContentController@redirect');
get('content/{part2}/{part1}.html{suffix?}', 'ContentController@redirect');
get('content/{part1}.html{suffix?}', 'ContentController@redirect');
*/

get('content/{legacy_path}', 'ContentController@redirect')
    ->where([
        'legacy_path' => '(.*)\.html(.*)'
]);

get('content/index/{type}', 'ContentController@index')
    ->where([
        'type' => config('content.allowed')
]);

get('content/{type}/create', 'ContentController@create')
    ->where([
        'type' => config('content.allowed')
]);

post('content/{type}', 'ContentController@store')
    ->where([
        'type' => config('content.allowed')
]);

get('content/{id}/edit', 'ContentController@edit');

get('content/{id}', 'ContentController@show');

put('content/{id}', 'ContentController@update');


// Comments

post('content/{id}/comment', 'CommentController@store');

get('comment/{id}/edit', 'CommentController@edit');

put('comment/{id}', 'CommentController@update');


// Users

get('user/{id}/messages/{user_id_with}', 'UserController@showMessagesWith');

get('user/{id}/messages', 'UserController@showMessages');

get('user/{id}/follows', 'UserController@showFollows');

get('user/{id}', 'UserController@show');


// Registration

Route::get('auth/register', 'Auth\AuthController@getRegister');

Route::post('auth/register', 'Auth\AuthController@postRegister');


// Authentication

Route::get('auth/login', 'Auth\AuthController@getLogin');

Route::post('auth/login', 'Auth\AuthController@postLogin');

Route::get('auth/logout', 'Auth\AuthController@getLogout');


// Password reset

Route::get('password/email', 'Auth\PasswordController@getEmail');

Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');

Route::post('password/reset', 'Auth\PasswordController@postReset');

// Ad debug

Route::get('ads', 'AdController@index');

