<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ContentController;

// Frontpage

Route::get('/', ['uses' => 'FrontpageController@index', 'as' => 'frontpage.index']);

Route::post('/', ['uses' => 'FrontpageController@search', 'as' => 'frontpage.search']);

//search
Route::get('search', ['uses' => 'SearchController@search', 'as' => 'search.results']);
Route::get('search/ajaxsearch', ['uses' => 'SearchController@ajaxsearch', 'as' => 'search.ajax']);
Route::get('search/{token}', ['uses' => 'SearchController@search', 'as' => 'search.results.type']);

// Registration

Route::get('register', ['middleware' => 'guest', 'uses' => 'Auth\RegistrationController@form', 'as' => 'register.form']);

Route::post('register', ['middleware' => 'guest', 'uses' => 'Auth\RegistrationController@submit', 'as' => 'register.submit']);

Route::get('register/confirm/{token}', ['uses' => 'Auth\RegistrationController@confirm', 'as' => 'register.confirm']);

// Login and logout

Route::get('login', ['middleware' => 'guest', 'uses' => 'Auth\LoginController@form', 'as' => 'login.form']);

Route::post('login', ['middleware' => 'guest', 'uses' => 'Auth\LoginController@submit', 'as' => 'login.submit']);

Route::get('logout', ['middleware' => 'auth', 'uses' => 'Auth\LoginController@logout', 'as' => 'login.logout']);

// Facebook login

Route::get('redirect/facebook', ['middleware' => 'guest', 'uses' => 'SocialController@facebookRedirect', 'as' => 'facebook.redirect']);

Route::get('facebook', ['uses' => 'SocialController@facebook', 'as' => 'facebook']);

// Google+ login

Route::get('redirect/google', ['middleware' => 'guest', 'uses' => 'SocialController@googleRedirect', 'as' => 'google.redirect']);

Route::get('google', ['uses' => 'SocialController@google', 'as' => 'google']);

// Password reset

Route::get('reset/apply', ['uses' => 'Auth\ResetController@applyForm', 'as' => 'reset.apply.form']);

Route::post('reset/apply', ['uses' => 'Auth\ResetController@postEmail', 'as' => 'reset.apply.submit']);

Route::get('reset/password/{token}', ['uses' => 'Auth\ResetController@passwordForm', 'as' => 'reset.password.form']);

Route::post('reset/password', ['uses' => 'Auth\ResetController@postReset', 'as' => 'reset.password.submit']);

// Content

Route::group(['prefix' => 'content/{type}', 'as' => 'content.'], function () {
    Route::get('/', ['middleware' => null, 'uses' => 'ContentController@index', 'as' => 'index']);

    Route::get('create', ['middleware' => 'role:regular', 'as' => 'create', function ($type) {
        $controller = new ContentController;
        if (\Auth::user()->hasRole('admin') && in_array($type, config('content.admin_only_edit'))) {
            return $controller->create($type);
        } elseif (\Auth::user()->hasRole('regular') && in_array($type, config('content.everyone_can_edit'))) {
            return $controller->create($type);
        } else {
            abort(401);

            return false;
        }
    }]);

    Route::post('/', ['middleware' => 'role:regular', 'as' => 'store', function ($type, Request $request) {
        $controller = new ContentController;
        if (\Auth::user()->hasRole('admin') && in_array($type, config('content.admin_only_edit'))) {
            return $controller->store($request, $type);
        } elseif (\Auth::user()->hasRole('regular') && in_array($type, config('content.everyone_can_edit'))) {
            return $controller->store($request, $type);
        } else {
            abort(401);

            return false;
        }
    }]);

    Route::get('{id}', ['middleware' => null, 'uses' => 'ContentController@show', 'as' => 'show']);

    Route::get('{id}/edit', ['middleware' => 'role:admin,contentowner', 'as' => 'edit', function ($type, $id) {
        $controller = new ContentController;
        if (\Auth::user()->hasRole('admin') && in_array($type, config('content.admin_only_edit'))) {
            return $controller->edit($type, $id);
        } elseif (\Auth::user()->hasRole('regular') && in_array($type, config('content.everyone_can_edit'))) {
            return $controller->edit($type, $id);
        } else {
            abort(401);

            return false;
        }
    }]);

    Route::put('{id}', ['middleware' => 'role:admin,contentowner', 'uses' => 'ContentController@store', 'as' => 'update']);

    Route::put('{id}/status/{status}', ['middleware' => 'role:admin', 'uses' => 'ContentController@status', 'as' => 'status']);

    Route::post('/filter', ['middleware' => null, 'uses' => 'ContentController@filter', 'as' => 'filter']);
});

// Additional blog (DUMMY)
//Route::get('content/blog/profile', ['uses' => 'ContentController@blog_profile', 'as' => 'content.show.profile']);

// Comments

Route::post('content/{type}/{id}/comment', ['middleware' => 'role:regular', 'uses' => 'CommentController@store', 'as' => 'comment.store']);

Route::get('comment/{id}/edit', ['middleware' => 'role:admin,commentowner', 'uses' => 'CommentController@edit', 'as' => 'comment.edit']);

Route::put('comment/{id}', ['middleware' => 'role:admin,commentowner', 'uses' => 'CommentController@update', 'as' => 'comment.update']);

Route::put('comment/{id}/status/{status}', ['middleware' => 'role:admin', 'uses' => 'CommentController@status', 'as' => 'comment.status']);

// Users

Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

    // get('/', ['uses' => 'UserController@index', 'as' => 'index']);

    // get('create', ['middleware' => 'auth', 'uses' => 'UserController@create', 'as' => 'create']);

    // post('/', ['middleware' => 'auth', 'uses' => 'UserController@store', 'as' => 'store']);

    Route::get('{id}', ['uses' => 'UserController@show', 'as' => 'show']);

    Route::get('{id}/edit', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@edit', 'as' => 'edit']);

    Route::put('{id}', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@update', 'as' => 'update']);

    Route::get('{id}/destinations', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@destinationsIndex', 'as' => 'destinations']);

    Route::post('{id}/destinations', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@destinationStore', 'as' => 'destination.store']);
});

// Messages

Route::get('user/{id}/messages', ['middleware' => 'role:superuser,userowner', 'uses' => 'MessageController@index', 'as' => 'message.index']);

Route::get('user/{id}/messages/{id2}', ['middleware' => 'role:superuser,userowner', 'uses' => 'MessageController@indexWith', 'as' => 'message.index.with']);

Route::post('message/{id}/to/{id2}', ['middleware' => 'role:superuser,userowner', 'uses' => 'MessageController@store', 'as' => 'message.store']);

// Follows

Route::get('user/{id}/follows', ['middleware' => 'role:admin,userowner', 'uses' => 'FollowController@index', 'as' => 'follow.index']);

Route::put('content/{type}/{id}/follow/{status}', ['middleware' => 'role:regular', 'uses' => 'FollowController@followContent', 'as' => 'follow.follow.content']);

// Admin

Route::get('admin/image', ['middleware' => 'role:admin', 'uses' => 'AdminController@imageIndex', 'as' => 'admin.image.index']);

Route::post('admin/image', ['middleware' => 'role:admin', 'uses' => 'AdminController@imageStore', 'as' => 'admin.image.store']);

Route::get('admin/content', ['middleware' => 'role:admin', 'uses' => 'AdminController@contentIndex', 'as' => 'admin.content.index']);

// Destinations

Route::get('destination/{id}', ['uses' => 'DestinationController@show', 'as' => 'destination.show']);

// Flags

Route::get('flag/{flaggable_type}/{flaggable_id}/{flag_type}', ['middleware' => 'role:regular', 'uses' => 'FlagController@toggle', 'as' => 'flag.toggle']);

// Atom feed

Route::get('index.atom', ['uses' => 'FeedController@index', 'as' => 'feed']);

// Styleguide

Route::get('styleguide', 'StyleguideController@index');

/*
 * Redirect old URL-s
 */

// Legacy content paths

Route::get('node/{id}', 'RedirectController@redirectNode');

Route::get('content/{path}', 'RedirectController@redirectContent')
    ->where('path', '.*');

// Legacy term paths

Route::get('taxonomy/term/{id}', 'RedirectController@redirectTaxonomy');

Route::get('sihtkoht/{title}', 'RedirectController@redirectDestination');

Route::get('category/{part1}/{part2}/{part3?}/{part4?}', 'RedirectController@redirectCategory');

// All other content pages

Route::get('{path}', 'RedirectController@redirectContentBySlug');
