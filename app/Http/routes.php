<?php

// Frontpage

get('/', 'FrontpageController@index');


// Content

get('content/index/{type}', 'ContentController@index')
    ->where([
        'type' => config('content.allowed')
]);

get('content/{type}/add', 'ContentController@add')
    ->where([
        'type' => config('content.allowed')
]);

get('content/{id}', 'ContentController@show');


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