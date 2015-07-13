<?php

// Frontpage

get('/', 'FrontpageController@index');

// Legacy paths

get('content/{legacy_path}', 'ContentController@redirect')
    ->where(['legacy_path' => '(.*)\.html(.*)']);

// Content

Route::group(['prefix' => 'content/{type}', 'as' => 'content.'], function () {
       
    get('/', ['uses' => 'ContentController@index', 'as' => 'index']);

    get('create', ['middleware' => 'auth', 'uses' => 'ContentController@create', 'as' => 'create']);

    post('/', ['middleware' => 'auth', 'uses' => 'ContentController@store', 'as' => 'store']);

    get('{id}', ['uses' => 'ContentController@show', 'as' => 'show']);

    get('{id}/edit', ['middleware' => 'auth', 'uses' => 'ContentController@edit', 'as' => 'edit']);

    put('{id}', ['middleware' => 'auth', 'uses' => 'ContentController@update', 'as' => 'update']);

});


// Comments

post('content/{id}/comment', ['middleware' => 'auth', 'uses' => 'CommentController@store', 'as' => 'comment.store']);

get('comment/{id}/edit', ['middleware' => 'auth', 'uses' => 'CommentController@edit', 'as' => 'comment.edit']);

put('comment/{id}', ['middleware' => 'auth', 'uses' => 'CommentController@update', 'as' => 'comment.update']);


// Users

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
       
    // get('/', ['uses' => 'UserController@index', 'as' => 'index']);

    // get('create', ['middleware' => 'auth', 'uses' => 'UserController@create', 'as' => 'create']);

    // post('/', ['middleware' => 'auth', 'uses' => 'UserController@store', 'as' => 'store']);

    get('{id}', ['uses' => 'UserController@show', 'as' => 'show']);

    // get('{id}/edit', ['middleware' => 'auth', 'uses' => 'UserController@edit', 'as' => 'edit']);

    // put('{id}', ['middleware' => 'auth', 'uses' => 'UserController@update', 'as' => 'update']);

    get('{id}/messages/{user_id_with}', ['middleware' => 'auth', 'uses' => 'UserController@showMessagesWith', 'as' => 'show.messages.with']);

    get('{id}/messages', ['middleware' => 'auth', 'uses' => 'UserController@showMessages', 'as' => 'show.messages']);

    get('{id}/follows', ['middleware' => 'auth', 'uses' => 'UserController@showFollows', 'as' => 'show.follows']);

});




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

