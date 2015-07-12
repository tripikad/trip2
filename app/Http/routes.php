<?php

// Frontpage

get('/', 'FrontpageController@index');

// Legacy paths

get('content/{legacy_path}', 'ContentController@redirect')
    ->where(['legacy_path' => '(.*)\.html(.*)']);

// Content

Route::group(['prefix' => 'content/{type}', 'as' => 'content.'], function () {
       
    get('/', ['uses' => 'ContentController@index', 'as' => 'index']);

    get('create', ['uses' => 'ContentController@create', 'as' => 'create']);

    post('/', ['uses' => 'ContentController@store', 'as' => 'store']);

    get('{id}/edit', ['uses' => 'ContentController@edit', 'as' => 'edit']);

    get('{id}', ['uses' => 'ContentController@show', 'as' => 'show']);

    put('{id}', ['uses' => 'ContentController@update', 'as' => 'updates']);

});

// Comments

post('content/{id}/comment', ['uses' => 'CommentController@store', 'as' => 'comment.store']);

get('comment/{id}/edit', ['uses' => 'CommentController@edit', 'as' => 'comment.edit']);

put('comment/{id}', ['uses' => 'CommentController@update', 'as' => 'comment.update']);

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

