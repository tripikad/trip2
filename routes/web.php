<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ContentController;

// V2

// Frontpage

Route::get('/', 'V2FrontpageController@index')
    ->name('frontpage.index');

// Content status

Route::post('content/{type}/{id}/status/{status}', 'ContentController@status')
    ->name('content.status')
    ->middleware('role:admin');

// News

Route::get('uudised', 'V2NewsController@index')
    ->name('news.index');

Route::get('uudised/{slug}', 'V2NewsController@show')
    ->name('news.show');

Route::get('news/create', 'V2NewsController@create')
    ->name('news.create')
    ->middleware('role:admin');

Route::post('news/store', 'V2NewsController@store')
    ->name('news.store')
    ->middleware('role:admin');

Route::get('news/{id}/edit', 'V2NewsController@edit')
    ->name('news.edit')
    ->middleware('role:admin');

Route::put('news/{id}/update', 'V2NewsController@update')
    ->name('news.update')
    ->middleware('role:admin');

// Flight

Route::get('odavad-lennupiletid', 'V2FlightController@index')
    ->name('flight.index');

Route::get('odavad-lennupiletid/{slug}', 'V2FlightController@show')
    ->name('flight.show');

Route::get('flight/create', 'V2FlightController@create')
    ->name('flight.create')
    ->middleware('role:admin');

Route::post('flight/store', 'V2FlightController@store')
    ->name('flight.store')
    ->middleware('role:admin');

Route::get('flight/{id}/edit', 'V2FlightController@edit')
    ->name('flight.edit')
    ->middleware('role:admin');

Route::put('flight/{id}/update', 'V2FlightController@update')
    ->name('flight.update')
    ->middleware('role:admin');

// Travelmates

Route::get('reisikaaslased', 'V2TravelmateController@index')
    ->name('travelmate.index');

Route::get('reisikaaslased/{slug}', 'V2TravelmateController@show')
    ->name('travelmate.show');

Route::get('travelmate/create', 'V2TravelmateController@create')
    ->name('travelmate.create')
    ->middleware('role:regular');

Route::post('travelmate/store', 'V2TravelmateController@store')
    ->name('travelmate.store')
    ->middleware('role:regular');

Route::get('travelmate/{id}/edit', 'V2TravelmateController@edit')
    ->name('travelmate.edit')
    ->middleware('role:admin,contentowner');

Route::put('travelmate/{id}/update', 'V2TravelmateController@update')
    ->name('travelmate.update')
   ->middleware('role:admin,contentowner');

// Forum

Route::get('foorum/uldfoorum', 'V2ForumController@forumIndex')
    ->name('forum.index');

Route::get('foorum/ost-muuk', 'V2ForumController@buysellIndex')
    ->name('buysell.index');

Route::get('foorum/elu-valimaal', 'V2ForumController@expatIndex')
    ->name('expat.index');

Route::get('foorum/uldfoorum/{slug}', 'V2ForumController@show')
    ->name('forum.show');

Route::get('foorum/ost-muuk/{slug}', 'V2ForumController@show')
    ->name('buysell.show');

Route::get('foorum/elu-valimaal/{slug}', 'V2ForumController@show')
    ->name('expat.show');

Route::get('forum/create', 'V2ForumController@create')
    ->name('forum.create')
    ->middleware('role:regular');

Route::post('forum/store', 'V2ForumController@store')
    ->name('forum.store')
    ->middleware('role:regular');

Route::get('forum/{id}/edit', 'V2ForumController@edit')
    ->name('forum.edit')
    ->middleware('role:admin,contentowner');

Route::put('forum/{id}/update', 'V2ForumController@update')
    ->name('forum.update')
    ->middleware('role:admin,contentowner');

// Static

$static = collect([
    'tripist' => 1534,
    'kontakt' => 972,
    'reklaam' => 22125,
    'mis-on-veahind' => 97203,
    'kasutustingimused' => 25151,
]);

Route::get('{slug}', 'V2StaticController@show')
    ->name('static.show')
    ->where('slug', '('.collect($static)->keys()->implode('|').')');

Route::get('static/{id}', function ($id) use ($static) {
    $slug = $static->flip()->get($id);
    return redirect()->route('static.show', [$slug]);
})
    ->name('static.show.id');

Route::get('static/{id}/edit', 'V2StaticController@edit')
    ->name('static.edit')
    ->middleware('role:superuser');

Route::post('static/{id}/update', 'V2StaticController@update')
    ->name('static.update')
    ->middleware('role:superuser');

// Blog

Route::get('reisikirjad', 'V2BlogController@index')
    ->name('blog.index');

Route::get('reisikirjad/{slug}', 'V2BlogController@show')
    ->name('blog.show');

Route::get('blog/create', 'V2BlogController@create')
    ->name('blog.create')
    ->middleware('role:regular');

Route::post('blog/store', 'V2BlogController@store')
    ->name('blog.store')
    ->middleware('role:regular');

Route::get('blog/{id}/edit', 'V2BlogController@edit')
    ->name('blog.edit')
    ->middleware('role:admin,contentowner');

Route::post('blog/{id}/update', 'V2BlogController@update')
    ->name('blog.update')
    ->middleware('role:admin,contentowner');

// Internal

Route::get('internal', 'V2AdminController@index')
    ->name('internal.index')
    ->middleware('role:admin');

Route::get('internal/{id}', 'V2AdminController@show')
    ->name('internal.show')
    ->middleware('role:admin');

Route::get('internal/create', 'V2AdminController@create')
    ->name('internal.create')
    ->middleware('role:admin');

Route::post('internal/store', 'V2AdminController@store')
    ->name('internal.store')
    ->middleware('role:admin');

Route::get('internal/{id}/edit', 'V2AdminController@edit')
    ->name('internal.edit')
    ->middleware('role:admin');

Route::post('internal/{id}/update', 'V2AdminController@update')
    ->name('internal.update')
    ->middleware('role:admin');

Route::get('admin/content', 'V2AdminController@unpublishedIndex')
    ->name('admin.content.index')
    ->middleware('role:admin');

// Photo

Route::get('reisipildid', 'V2PhotoController@index')
    ->name('photo.index');

Route::get('photo/id/{id}', 'V2PhotoController@show') // Placeholder
    ->name('photo.show');

Route::get('photo/create', 'V2PhotoController@create')
    ->name('photo.create')
    ->middleware('role:regular');

Route::post('photo/store', 'V2PhotoController@store')
    ->name('photo.store')
    ->middleware('role:regular');

Route::get('photo/{id}/edit', 'V2PhotoController@edit')
    ->name('photo.edit')
    ->middleware('role:admin,contentowner');

Route::put('photo/{id}/update', 'V2PhotoController@update')
    ->name('photo.update')
    ->middleware('role:admin,contentowner');

// Content redirects
// TOOD: move to separate controller

Route::get('content/{type}', function ($type) {
    return redirect()->route("$type.index", 301);
})
    ->name('content.index');

Route::get('content/{type}/{id}', function ($type, $id) {
    $content = App\Content::findOrFail($id);

    return redirect()->route("$type.show", [$content->slug], 301);
})
    ->name('content.show');

// User

Route::get('user/{id}', 'V2UserController@show')
    ->name('user.show');

Route::get('user/{id}/edit', 'UserController@edit')
    ->name('user.edit')
    ->middleware('role:superuser,userowner');

Route::put('user/{id}/update', 'UserController@update')
    ->name('user.update')
    ->middleware('role:superuser,userowner');

Route::get('{id}/destinations', 'UserController@destinationsIndex')
    ->middleware('role:admin,userowner')
    ->name('user.destinations');

Route::post('{id}/destinations', 'UserController@destinationStore')
    ->middleware('role:admin,userowner')
    ->name('user.destination.store');

Route::get('user/{id}/photo', 'V2PhotoController@userIndex')
    ->name('photo.user');

// Messages

Route::get('user/{id}/messages', 'V2MessageController@index')
    ->name('message.index')
    ->middleware('role:superuser,userowner');

Route::get('user/{id}/messages/{id2}', 'V2MessageController@indexWith')
    ->name('message.index.with')
    ->middleware('role:superuser,userowner');

Route::post('message/{id}/to/{id2}', 'MessageController@store')
    ->name('message.store')
    ->middleware('role:superuser,userowner');

// Follows

Route::get('user/{id}/follows', 'V2ForumController@followIndex')
    ->name('follow.index')
    ->middleware('role:admin,userowner');

Route::put('content/{type}/{id}/follow/{status}', 'FollowController@followContent')
    ->name('follow.follow.content')
    ->middleware('role:regular');

// Destination

// TODO: both id and slug versions

Route::get('sihtkoht/{id}', [
    'uses' => 'V2DestinationController@show',
    'as' => 'destination.show',
]);

Route::get('sihtkoht/{slug}', [
    'uses' => 'V2DestinationController@showSlug',
    'as' => 'destination.showSlug',
]);

// Utils

Route::get('utils/alert', [
    'uses' => 'V2UtilsController@alert',
    'as' => 'utils.alert',
]);

Route::get('share/{social}', [
    'uses' => 'V2SocialController@share',
    'as' => 'utils.share',
]);

Route::post('utils/filter', 'V2UtilsController@filter')
    ->name('utils.filter');

// Experiments

Route::get('experiments', [
    'uses' => 'V2ExperimentsController@index',
    'as' => 'experiments.index',
]);

Route::get('experiments/error/{code}', [
    'uses' => 'V2ErrorController@show',
    'as' => 'error.show',
]);

// Search

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

// FB campaign

Route::get('tasuta-lennupiletid-maltale', ['uses' => 'CampaignController@index', 'as' => 'index']);
Route::get('tasuta-lennupiletid-maltale{path}', ['uses' => 'CampaignController@index', 'as' => 'index']);

// Flags

Route::get('flag/{flaggable_type}/{flaggable_id}/{flag_type}', ['middleware' => 'role:regular', 'uses' => 'FlagController@toggle', 'as' => 'flag.toggle']);

// Comments

Route::post('content/{type}/{id}/comment', ['middleware' => 'role:regular', 'uses' => 'CommentController@store', 'as' => 'comment.store']);

Route::get('comment/{id}/edit', ['middleware' => 'role:admin,commentowner', 'uses' => 'CommentController@edit', 'as' => 'comment.edit']);

Route::put('comment/{id}', ['middleware' => 'role:admin,commentowner', 'uses' => 'CommentController@update', 'as' => 'comment.update']);

Route::put('comment/{id}/status/{status}', ['middleware' => 'role:admin', 'uses' => 'CommentController@status', 'as' => 'comment.status']);

// Admin

Route::get('admin/image', ['middleware' => 'role:admin', 'uses' => 'AdminController@imageIndex', 'as' => 'admin.image.index']);

Route::post('admin/image', ['middleware' => 'role:admin', 'uses' => 'AdminController@imageStore', 'as' => 'admin.image.store']);

// Experiments

Route::get('/experiments/blog', ['middleware' => 'role:admin', 'uses' => 'BlogTestController@index', 'as' => 'index']);

Route::get('/experiments/blog/show', ['middleware' => 'role:admin', 'uses' => 'BlogTestController@show', 'as' => 'show']);

Route::get('/experiments/blog/edit', ['middleware' => 'role:admin', 'uses' => 'BlogTestController@edit', 'as' => 'edit']);

Route::get('/experiments/blog/profile', ['middleware' => 'role:admin', 'uses' => 'BlogTestController@profile', 'as' => 'profile']);

// Atom feeds

Route::get('index.atom', ['uses' => 'FeedController@newsFeed', 'as' => 'news.feed']);

Route::get('lendude_sooduspakkumised/rss', ['uses' => 'FeedController@flightFeed', 'as' => 'flight.feed']);

// API

Route::get('api/destinations', 'ApiController@destinations');

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

// V1

// Frontpage

//Route::get('/', ['uses' => 'FrontpageController@index', 'as' => 'frontpage.index']);

//Route::post('/', ['uses' => 'FrontpageController@search', 'as' => 'frontpage.search']);

//SEO content
/*
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
*/
//SEO static
/*
foreach (config('sluggable.staticContentMapping') as $static_id => $slug) {
    Route::get($slug, ['as' => 'static.'.$static_id, function () use ($static_id) {
        $controller = new ContentController;

        return $controller->show('static', $static_id);
    }]);
}
*/
//SEO destination

/*
Route::get('sihtkoht/{slug}', ['uses' => 'DestinationController@showSlug', 'as' => 'destination.slug']);
*/

// Content
/*
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

    //Route::get('{id}', ['uses' => 'ContentController@showWithRedirect', 'as' => 'show']);

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
    */
    /*
    Route::put('{id}', ['middleware' => 'role:admin,contentowner', 'uses' => 'ContentController@store', 'as' => 'update']);

    Route::put('{id}/status/{status}', ['middleware' => 'role:admin', 'uses' => 'ContentController@status', 'as' => 'status']);

    Route::post('/filter', ['uses' => 'ContentController@filter', 'as' => 'filter']);

});
*/

// Additional blog (DUMMY)
//Route::get('content/blog/profile', ['uses' => 'ContentController@blog_profile', 'as' => 'content.show.profile']);

// Blog test pages

// Users

//Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

    // get('/', ['uses' => 'UserController@index', 'as' => 'index']);

    // get('create', ['middleware' => 'auth', 'uses' => 'UserController@create', 'as' => 'create']);

    // post('/', ['middleware' => 'auth', 'uses' => 'UserController@store', 'as' => 'store']);
/*
    Route::get('{id}', ['uses' => 'UserController@show', 'as' => 'show']);

    Route::get('{id}/edit', ['middleware' => 'role:superuser,userowner', 'uses' => 'UserController@edit', 'as' => 'edit']);

    Route::put('{id}', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@update', 'as' => 'update']);

    Route::get('{id}/destinations', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@destinationsIndex', 'as' => 'destinations']);

    Route::post('{id}/destinations', ['middleware' => 'role:admin,userowner', 'uses' => 'UserController@destinationStore', 'as' => 'destination.store']);
    */
//});

// Messages
/*
Route::get('user/{id}/messages', ['middleware' => 'role:superuser,userowner', 'uses' => 'MessageController@index', 'as' => 'message.index']);

Route::get('user/{id}/messages/{id2}', ['middleware' => 'role:superuser,userowner', 'uses' => 'MessageController@indexWith', 'as' => 'message.index.with']);

Route::post('message/{id}/to/{id2}', ['middleware' => 'role:superuser,userowner', 'uses' => 'MessageController@store', 'as' => 'message.store']);
*/
// Follows
/*
Route::get('user/{id}/follows', ['middleware' => 'role:admin,userowner', 'uses' => 'FollowController@index', 'as' => 'follow.index']);

Route::put('content/{type}/{id}/follow/{status}', ['middleware' => 'role:regular', 'uses' => 'FollowController@followContent', 'as' => 'follow.follow.content']);
*/

// Destinations
/*
Route::get('destination/{id}', ['uses' => 'DestinationController@show', 'as' => 'destination.show']);
*/
// Flags
/*
Route::get('flag/{flaggable_type}/{flaggable_id}/{flag_type}', ['middleware' => 'role:regular', 'uses' => 'FlagController@toggle', 'as' => 'flag.toggle']);
*/
