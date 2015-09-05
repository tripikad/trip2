<?php

// Frontpage

get('/', ['uses' => 'FrontpageController@index', 'as' => 'frontpage.index']);

post('/', ['uses' => 'FrontpageController@search', 'as' => 'frontpage.search']);

// Registration

get('register', ['uses' => 'Auth\RegistrationController@form', 'as' => 'register.form']);

post('register', ['uses' => 'Auth\RegistrationController@submit', 'as' => 'register.submit']);

get('register/confirm/{token}', ['uses' => 'Auth\RegistrationController@confirm', 'as' => 'register.confirm']);


// Login and logout

get('login', ['uses' => 'Auth\LoginController@form', 'as' => 'login.form']);

post('login', ['uses' => 'Auth\LoginController@submit', 'as' => 'login.submit']);

get('logout', ['uses' => 'Auth\LoginController@logout', 'as' => 'login.logout']);

// Password reset

get('reset/apply', ['uses' => 'Auth\ResetController@applyForm', 'as' => 'reset.apply.form']);

post('reset/apply', ['uses' => 'Auth\ResetController@postEmail', 'as' => 'reset.apply.submit']);

get('reset/password/{token}', ['uses' => 'Auth\ResetController@passwordForm', 'as' => 'reset.password.form']);

post('reset/password', ['uses' => 'Auth\ResetController@postReset', 'as' => 'reset.password.submit']);


// Legacy content paths

get('content/{legacy_path}', 'ContentController@redirect')
    ->where(['legacy_path' => '(.*)\.html(.*)']);

// Content

Route::group(['prefix' => 'content/{type}', 'as' => 'content.'], function () {
       
    get('/', ['middleware' => null, 'uses' => 'ContentController@index', 'as' => 'index']);

    get('create', ['middleware' => 'role:regular', 'uses' => 'ContentController@create', 'as' => 'create']);

    post('/', ['middleware' => 'role:regular', 'uses' => 'ContentController@store', 'as' => 'store']);

    get('{id}', ['middleware' => null, 'uses' => 'ContentController@show', 'as' => 'show']);

    get('{id}/edit', ['middleware' => 'role:admin,contentowner', 'uses' => 'ContentController@edit', 'as' => 'edit']);

    put('{id}', ['middleware' => 'role:admin,contentowner', 'uses' => 'ContentController@update', 'as' => 'update']);

    get('{id}/status/{status}', ['middleware' => 'role:admin', 'uses' => 'ContentController@status', 'as' => 'status']);

    post('/filter', ['middleware' => null, 'uses' => 'ContentController@filter', 'as' => 'filter']);

});


// Comments

post('content/{type}/{id}/comment', ['middleware' => 'role:regular', 'uses' => 'CommentController@store', 'as' => 'comment.store']);

get('comment/{id}/edit', ['middleware' => 'role:admin,commentowner', 'uses' => 'CommentController@edit', 'as' => 'comment.edit']);

put('comment/{id}', ['middleware' => 'role:admin,commentowner', 'uses' => 'CommentController@update', 'as' => 'comment.update']);

get('comment/{id}/status/{status}', ['middleware' => 'role:admin', 'uses' => 'CommentController@status', 'as' => 'comment.status']);


// Users

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

    // get('/', ['uses' => 'UserController@index', 'as' => 'index']);

    // get('create', ['middleware' => 'auth', 'uses' => 'UserController@create', 'as' => 'create']);

    // post('/', ['middleware' => 'auth', 'uses' => 'UserController@store', 'as' => 'store']);

    get('{id}', ['uses' => 'UserController@show', 'as' => 'show']);

    get('{id}/edit', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@edit', 'as' => 'edit']);

    put('{id}', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@update', 'as' => 'update']);

    get('{id}/messages/{id2}', ['middleware' => 'role:superuser,userowner', 'uses' => 'UserController@showMessagesWith', 'as' => 'show.messages.with']);

    get('{id}/messages', ['middleware' => 'role:superuser,userowner', 'uses' => 'UserController@showMessages', 'as' => 'show.messages']);

    get('{id}/follows', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@showFollows', 'as' => 'show.follows']);

});

Route::group(['prefix' => 'message', 'as' => 'message.'], function () {

    post('{id}/to/{id2}', ['middleware' => 'role:superuser,userowner', 'uses' => 'MessageController@store', 'as' => 'store']);

});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    get('images', ['uses' => 'ImageController@index', 'as' => 'image.index']);

});



// Ad debug

get('ads', ['middleware' => 'role:admin', 'uses' => 'AdController@index', 'as' => 'ads']);

// Destinations

get('destination/{id}', ['uses' => 'DestinationController@index', 'as' => 'destination.index']);

// Flags

get('flag/{flaggable_type}/{flaggable_id}/{flag_type}', ['middleware' => 'role:regular', 'uses' => 'FlagController@toggle', 'as' => 'flag.toggle']);
