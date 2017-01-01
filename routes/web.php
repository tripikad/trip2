<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ContentController;

// V2

// Styleguide

Route::get('v2/index', [
    'uses' => 'V2StyleguideController@index',
    'as' => 'styleguide.index',
]);

Route::post('v2/styleguide/form', [
    'uses' => 'V2StyleguideController@form',
    'as' => 'styleguide.form',
]);

Route::post('v2/styleguide/flag', [
    'uses' => 'V2StyleguideController@flag',
    'as' => 'styleguide.flag',
]);

// Frontpage

Route::get('v2/frontpage', [
    'uses' => 'V2FrontpageController@index',
    'as' => 'v2.frontpage.index',
]);

// News

Route::get('v2/news', [
    'uses' => 'V2NewsController@index',
    'as' => 'v2.news.index',
]);

Route::get('v2/news/{slug}', [
    'uses' => 'V2NewsController@show',
    'as' => 'v2.news.show',
]);


// Flight

Route::get('v2/flight', [
    'uses' => 'V2FlightController@index',
    'as' => 'v2.flight.index',
]);

Route::get('v2/flight/{slug}', [
    'uses' => 'V2FlightController@show',
    'as' => 'v2.flight.show',
]);

// Travelmates

Route::get('v2/travelmate', [
    'uses' => 'V2TravelmateController@index',
    'as' => 'v2.travelmate.index',
]);

Route::get('v2/travelmate/{slug}', [
    'uses' => 'V2TravelmateController@show',
    'as' => 'v2.travelmate.show',
]);

// Forum

Route::get('v2/forum', [
    'uses' => 'V2ForumController@forumIndex',
    'as' => 'v2.forum.index',
]);

Route::get('v2/buysell', [
    'uses' => 'V2ForumController@buysellIndex',
    'as' => 'v2.buysell.index',
]);

Route::get('v2/expat', [
    'uses' => 'V2ForumController@expatIndex',
    'as' => 'v2.expat.index',
]);

Route::get('v2/forum/{slug}', [
    'uses' => 'V2ForumController@show',
    'as' => 'v2.forum.show',
]);

// Static

Route::get('v2/static', [
    'uses' => 'V2StaticController@index',
    'as' => 'v2.static.index',
]);

Route::get('v2/static/{id}', [
    'uses' => 'V2StaticController@show',
    'as' => 'v2.static.show',
]);

// User

Route::get('v2/user/{id}', [
    'uses' => 'V2UserController@show',
    'as' => 'v2.user.show',
]);

// Destination

Route::get('v2/destination/{id}', [
    'uses' => 'V2DestinationController@show',
    'as' => 'v2.destination.show',
]);

// Utils

Route::get('v2/utils/alert', [
    'uses' => 'V2UtilsController@alert',
    'as' => 'utils.alert',
]);

Route::get('share/{social}', [
    'uses' => 'V2SocialController@share',
    'as' => 'utils.share',
]);

Route::post('v2/utils/format', [
    'uses' => 'V2UtilsController@format',
    'as' => 'utils.format',
]);

Route::post('v2/image/store', [
    'uses' => 'V2StyleguideController@store',
    'as' => 'image.store',
]);

Route::post('v2/utils/filter', [
    'uses' => 'V2UtilsController@filter',
    'as' => 'utils.filter',
]);

// V1

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

Route::post('reset/password', ['uses' => 'Auth\ResetController@reset', 'as' => 'reset.password.submit']);

// Fb campaign

Route::get('tasuta-lennupiletid-maltale', ['uses' => 'CampaignController@index', 'as' => 'index']);
Route::get('tasuta-lennupiletid-maltale{path}', ['uses' => 'CampaignController@index', 'as' => 'index']);

//SEO content

foreach (array_flip(config('sluggable.contentTypeMapping')) as $slugType => $type) {
    Route::group(['prefix' => $slugType, 'as' => $type.'.'], function () use ($type) {
        Route::get('/', ['as' => 'index', function () use ($type) {
            $controller = new ContentController;

            return $controller->index(app('request'), $type);
        }]);

        Route::get('{slug}', ['as' => 'show', function ($slug) use ($type) {
            $controller = new ContentController;

            return $controller->findBySlugAndType($type, $slug);
        }]);
    });
}

//SEO static

foreach (config('sluggable.staticContentMapping') as $static_id => $slug) {
    Route::get($slug, ['as' => 'static.'.$static_id, function () use ($static_id) {
        $controller = new ContentController;

        return $controller->show('static', $static_id);
    }]);
}

//SEO destination

Route::get('sihtkoht/{slug}', ['uses' => 'DestinationController@showSlug', 'as' => 'destination.slug']);

// Content

Route::group(['prefix' => 'content/{type}', 'as' => 'content.'], function () {
    Route::get('/', ['as' => 'index', function ($type) {
        return redirect()->route(
            $type.'.index', [
        ], 301);
    }]);

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

    Route::get('{id}', ['uses' => 'ContentController@showWithRedirect', 'as' => 'show']);

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

    Route::post('/filter', ['uses' => 'ContentController@filter', 'as' => 'filter']);
});

// Additional blog (DUMMY)
//Route::get('content/blog/profile', ['uses' => 'ContentController@blog_profile', 'as' => 'content.show.profile']);

// Blog test pages

Route::get('/blogtest', ['middleware' => 'role:admin', 'uses' => 'BlogTestController@index', 'as' => 'index']);
Route::get('/blogtest/show', ['middleware' => 'role:admin', 'uses' => 'BlogTestController@show', 'as' => 'show']);
Route::get('/blogtest/edit', ['middleware' => 'role:admin', 'uses' => 'BlogTestController@edit', 'as' => 'edit']);
Route::get('/blogtest/profile', ['middleware' => 'role:admin', 'uses' => 'BlogTestController@profile', 'as' => 'profile']);

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

    Route::get('{id}/edit', ['middleware' => 'role:superuser,userowner', 'uses' => 'UserController@edit', 'as' => 'edit']);

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

// Atom feeds

Route::get('index.atom', ['uses' => 'FeedController@newsFeed', 'as' => 'news.feed']);

Route::get('lendude_sooduspakkumised/rss', ['uses' => 'FeedController@flightFeed', 'as' => 'flight.feed']);

// API

Route::get('api/destinations', 'ApiController@destinations');

/*
 * Redirect old URL-s
 */

// Legacy user paths

Route::get('user/{id}/forum', 'RedirectController@redirectUser');

Route::get('sein/user/{id}', 'RedirectController@redirectUser');

// Legacy term paths

Route::get('taxonomy/term/{id}/{a?}', 'RedirectController@redirectTaxonomy');

Route::get('node/taxonomy/term/{id}', 'RedirectController@redirectTaxonomy');

Route::get('content/taxonomy/term/{id}', 'RedirectController@redirectTaxonomy');

Route::get('content/{blurb}/taxonomy/term/{id}', 'RedirectController@redirectTaxonomyBlurb');

Route::get('trip_destination/tid/{id}', 'RedirectController@redirectTaxonomy');

Route::get('sihtkoht/{title}', 'RedirectController@redirectDestination');

Route::get(
    'content/{blurb}/sihtkoht/{title}',
    'RedirectController@redirectDestinationBlurb'
);

Route::get(
    'content/{blurb}/{blurb2}/sihtkoht/{title}',
    'RedirectController@redirectDestinationBlurb2'
);

Route::get('node/sihtkoht/{title}', 'RedirectController@redirectDestination');

Route::get('content/sihtkoht/{title}', 'RedirectController@redirectDestination');

Route::get('category/{part1}/{part2}/{part3?}/{part4?}', 'RedirectController@redirectCategory');

Route::get('node/category/{part1}/{part2}/{part3?}/{part4?}', 'RedirectController@redirectCategory');

Route::get(
    'content/category/{part1}/{part2}/{part3?}/{part4?}',
    'RedirectController@redirectCategory'
);

Route::get(
    'content/{blurb}/category/{part1}/{part2}/{part3?}/{part4?}',
    'RedirectController@redirectCategoryBlurb'
);

Route::get(
    'sein/term/{id}/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}/{h?}/{i?}/{j?}/{k?}/{l?}/{m?}/{n?}',
    'RedirectController@redirectTaxonomy'
);

// Legacy content paths

Route::get(
    'node/{id}/{a?}/{b?}/{c?}/{d?}/{e?}/{f?}/{g?}/{h?}/{i?}/{j?}/{k?}/{l?}/{m?}/{n?}',
    'RedirectController@redirectNode'
);

Route::get('node/view/{id}', 'RedirectController@redirectNode');

Route::get('node.php?id={id}', 'RedirectController@redirectNode');

Route::get('blog/{id}', 'RedirectController@redirectNode');

Route::get('content/news/{id}', 'RedirectController@redirectNode');

Route::get('sein/user/node/{id}', 'RedirectController@redirectNode');

Route::get('node/{id}/atom/feed', 'RedirectController@redirectNode');

Route::get('crss/node/{id}', 'RedirectController@redirectNode');

Route::get('content/{path}', 'RedirectController@redirectContent')
    ->where('path', '.*');

// All other legacy aliases

Route::get('{part1}/{part2?}', 'RedirectController@redirectAlias');
