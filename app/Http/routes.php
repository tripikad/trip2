<?php

// Frontpage

get('/', 'FrontpageController@index');

// Legacy paths

get('content/{legacy_path}', 'ContentController@redirect')
    ->where(['legacy_path' => '(.*)\.html(.*)']);

// Content

Route::group(['prefix' => 'content/{type}', 'as' => 'content.'], function () {
       
    get('/', ['middleware' => null, 'uses' => 'ContentController@index', 'as' => 'index']);

    get('create', ['middleware' => 'role:regular', 'uses' => 'ContentController@create', 'as' => 'create']);

    post('/', ['middleware' => 'role:regular', 'uses' => 'ContentController@store', 'as' => 'store']);

    get('{id}', ['middleware' => null, 'uses' => 'ContentController@show', 'as' => 'show']);

    get('{id}/edit', ['middleware' => 'role:admin', 'uses' => 'ContentController@edit', 'as' => 'edit']);

    put('{id}', ['middleware' => 'role:admin', 'uses' => 'ContentController@update', 'as' => 'update']);

});


// Comments

post('content/{type}/{id}/comment', ['middleware' => 'role:regular', 'uses' => 'CommentController@store', 'as' => 'comment.store']);

get('comment/{id}/edit', ['middleware' => 'role:admin', 'uses' => 'CommentController@edit', 'as' => 'comment.edit']);

put('comment/{id}', ['middleware' => 'role:admin', 'uses' => 'CommentController@update', 'as' => 'comment.update']);


// Users

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
       
    // get('/', ['uses' => 'UserController@index', 'as' => 'index']);

    // get('create', ['middleware' => 'auth', 'uses' => 'UserController@create', 'as' => 'create']);

    // post('/', ['middleware' => 'auth', 'uses' => 'UserController@store', 'as' => 'store']);

    get('{id}', ['uses' => 'UserController@show', 'as' => 'show']);

    // get('{id}/edit', ['middleware' => 'auth', 'uses' => 'UserController@edit', 'as' => 'edit']);

    // put('{id}', ['middleware' => 'auth', 'uses' => 'UserController@update', 'as' => 'update']);

    get('{id}/messages/{id2}', ['middleware' => 'role:admin', 'uses' => 'UserController@showMessagesWith', 'as' => 'show.messages.with']);

    get('{id}/messages', ['middleware' => 'role:admin', 'uses' => 'UserController@showMessages', 'as' => 'show.messages']);

    get('{id}/follows', ['middleware' => 'role:admin', 'uses' => 'UserController@showFollows', 'as' => 'show.follows']);

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

Route::get('ads', ['middleware' => 'role:admin', 'uses' => 'AdController@index']);

