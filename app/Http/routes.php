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

// Facebook login

get('redirect/facebook', ['middleware' => null, 'uses' => 'SocialController@facebookRedirect', 'as' => 'facebook.redirect']);

get('facebook', ['uses' => 'SocialController@facebook', 'as' => 'facebook']);

// Google+ login

get('redirect/google', ['middleware' => null, 'uses' => 'SocialController@googleRedirect', 'as' => 'google.redirect']);

get('google', ['uses' => 'SocialController@google', 'as' => 'google']);

// Password reset

get('reset/apply', ['uses' => 'Auth\ResetController@applyForm', 'as' => 'reset.apply.form']);

post('reset/apply', ['uses' => 'Auth\ResetController@postEmail', 'as' => 'reset.apply.submit']);

get('reset/password/{token}', ['uses' => 'Auth\ResetController@passwordForm', 'as' => 'reset.password.form']);

post('reset/password', ['uses' => 'Auth\ResetController@postReset', 'as' => 'reset.password.submit']);

// Content

Route::group(['prefix' => 'content/{type}', 'as' => 'content.'], function () {

    get('/', ['middleware' => null, 'uses' => 'ContentController@index', 'as' => 'index']);

    get('create', ['middleware' => 'role:regular', 'uses' => 'ContentController@create', 'as' => 'create']);

    post('/', ['middleware' => 'role:regular', 'uses' => 'ContentController@store', 'as' => 'store']);

    get('{id}', ['middleware' => null, 'uses' => 'ContentController@show', 'as' => 'show']);

    get('{id}/edit', ['middleware' => 'role:admin,contentowner', 'uses' => 'ContentController@edit', 'as' => 'edit']);

    put('{id}', ['middleware' => 'role:admin,contentowner', 'uses' => 'ContentController@update', 'as' => 'update']);

    put('{id}/status/{status}', ['middleware' => 'role:admin', 'uses' => 'ContentController@status', 'as' => 'status']);

    post('/filter', ['middleware' => null, 'uses' => 'ContentController@filter', 'as' => 'filter']);

});

// Comments

post('content/{type}/{id}/comment', ['middleware' => 'role:regular', 'uses' => 'CommentController@store', 'as' => 'comment.store']);

get('comment/{id}/edit', ['middleware' => 'role:admin,commentowner', 'uses' => 'CommentController@edit', 'as' => 'comment.edit']);

put('comment/{id}', ['middleware' => 'role:admin,commentowner', 'uses' => 'CommentController@update', 'as' => 'comment.update']);

put('comment/{id}/status/{status}', ['middleware' => 'role:admin', 'uses' => 'CommentController@status', 'as' => 'comment.status']);

// Users

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

    // get('/', ['uses' => 'UserController@index', 'as' => 'index']);

    // get('create', ['middleware' => 'auth', 'uses' => 'UserController@create', 'as' => 'create']);

    // post('/', ['middleware' => 'auth', 'uses' => 'UserController@store', 'as' => 'store']);

    get('{id}', ['uses' => 'UserController@show', 'as' => 'show']);

    get('{id}/edit', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@edit', 'as' => 'edit']);

    put('{id}', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@update', 'as' => 'update']);

    get('{id}/destinations', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@destinationsIndex', 'as' => 'destinations']);

    post('{id}/destinations', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@destinationStore', 'as' => 'destination.store']);

});

// Messages

get('user/{id}/messages', ['middleware' => 'role:superuser,userowner', 'uses' => 'MessageController@index', 'as' => 'message.index']);

get('user/{id}/messages/{id2}', ['middleware' => 'role:superuser,userowner', 'uses' => 'MessageController@indexWith', 'as' => 'message.index.with']);

post('message/{id}/to/{id2}', ['middleware' => 'role:superuser,userowner', 'uses' => 'MessageController@store', 'as' => 'message.store']);

// Follows

get('user/{id}/follows', ['middleware' => 'role:admin,userowner', 'uses' => 'FollowController@index', 'as' => 'follow.index']);

put('content/{type}/{id}/follow/{status}', ['middleware' => 'role:regular', 'uses' => 'FollowController@followContent', 'as' => 'follow.follow.content']);

// Admin

get('admin/image', ['middleware' => 'role:admin', 'uses' => 'AdminController@imageIndex', 'as' => 'admin.image.index']);

post('admin/image', ['middleware' => 'role:admin', 'uses' => 'AdminController@imageStore', 'as' => 'admin.image.store']);

get('admin/content', ['middleware' => 'role:admin', 'uses' => 'AdminController@contentIndex', 'as' => 'admin.content.index']);

// Destinations

get('destination/{id}', ['uses' => 'DestinationController@show', 'as' => 'destination.show']);

// Flags

get('flag/{flaggable_type}/{flaggable_id}/{flag_type}', ['middleware' => 'role:regular', 'uses' => 'FlagController@toggle', 'as' => 'flag.toggle']);

// Atom feed

get('index.atom', ['uses' => 'FeedController@index', 'as' => 'feed']);

// Styleguide

get('styleguide', 'StyleguideController@index');

/*
 * Redirect old URL-s
 */

// Legacy content paths

get('node/{id}', 'RedirectController@redirectNode');

get('content/{path}', 'RedirectController@redirectContent')
    ->where('path', '.*');

// Legacy term paths

get('taxonomy/term/{id}', 'RedirectController@redirectTaxonomy');

get('sihtkoht/{title}', 'RedirectController@redirectDestination');

get('category/{part1}/{part2}/{part3?}/{part4?}', 'RedirectController@redirectCategory');

// All other content pages

get('{path}', 'RedirectController@redirectContentBySlug');
