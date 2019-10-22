<?php

// Frontpage

Route::get('/', 'FrontpageController@index')->name(
    'frontpage.index'
);

// Content status

Route::post(
    'content/{type}/{id}/status/{status}',
    'ContentController@status'
)
    ->name('content.status')
    ->middleware('role:admin');

// News

Route::get('uudised', 'NewsController@index')->name(
    'news.index'
);

Route::get('uudised/{slug}', 'NewsController@show')->name(
    'news.show'
);

Route::get('news/create', 'NewsController@create')
    ->name('news.create')
    ->middleware('role:admin');

Route::post('news/store', 'NewsController@store')
    ->name('news.store')
    ->middleware('role:admin');

Route::get('news/{id}/edit', 'NewsController@edit')
    ->name('news.edit')
    ->middleware('role:admin');

Route::put('news/{id}/update', 'NewsController@update')
    ->name('news.update')
    ->middleware('role:admin');

// Shortnews

Route::get(
    'luhiuudised',
    'NewsController@shortnewsIndex'
)->name('shortnews.index');

Route::get(
    'luhiuudised/{slug}',
    'NewsController@show'
)->name('shortnews.show');

// Flight

Route::get(
    'odavad-lennupiletid',
    'FlightController@index'
)->name('flight.index');

Route::get(
    'odavad-lennupiletid/{slug}',
    'FlightController@show'
)->name('flight.show');

Route::get('flight/create', 'FlightController@create')
    ->name('flight.create')
    ->middleware('role:admin');

Route::post('flight/store', 'FlightController@store')
    ->name('flight.store')
    ->middleware('role:admin');

Route::get('flight/{id}/edit', 'FlightController@edit')
    ->name('flight.edit')
    ->middleware('role:admin');

Route::put('flight/{id}/update', 'FlightController@update')
    ->name('flight.update')
    ->middleware('role:admin');

// Travelmates

Route::get(
    'reisikaaslased',
    'TravelmateController@index'
)->name('travelmate.index');

Route::get(
    'reisikaaslased/{slug}',
    'TravelmateController@show'
)->name('travelmate.show');

Route::get(
    'travelmate/create',
    'TravelmateController@create'
)
    ->name('travelmate.create')
    ->middleware('role:regular');

Route::post(
    'travelmate/store',
    'TravelmateController@store'
)
    ->name('travelmate.store')
    ->middleware('role:regular');

Route::get(
    'travelmate/{id}/edit',
    'TravelmateController@edit'
)
    ->name('travelmate.edit')
    ->middleware('role:admin,contentowner');

Route::put(
    'travelmate/{id}/update',
    'TravelmateController@update'
)
    ->name('travelmate.update')
    ->middleware('role:admin,contentowner');

// Forum

Route::get(
    'foorum/uldfoorum',
    'ForumController@forumIndex'
)->name('forum.index');

Route::get(
    'foorum/ost-muuk',
    'ForumController@buysellIndex'
)->name('buysell.index');

Route::get(
    'foorum/elu-valimaal',
    'ForumController@expatIndex'
)->name('expat.index');

Route::get(
    'foorum/vaba-teema',
    'ForumController@miscIndex'
)->name('misc.index');

Route::get(
    'foorum/uldfoorum/{slug}',
    'ForumController@show'
)->name('forum.show');

Route::get(
    'foorum/ost-muuk/{slug}',
    'ForumController@show'
)->name('buysell.show');

Route::get(
    'foorum/elu-valimaal/{slug}',
    'ForumController@show'
)->name('expat.show');

Route::get(
    'foorum/vaba-teema/{slug}',
    'ForumController@show'
)->name('misc.show');

Route::get('forum/create/{type}', 'ForumController@create')
    ->name('forum.create')
    ->middleware('role:regular');

Route::post('forum/store', 'ForumController@store')
    ->name('forum.store')
    ->middleware('role:regular');

Route::get('forum/{id}/edit', 'ForumController@edit')
    ->name('forum.edit')
    ->middleware('role:admin,contentowner');

Route::put('forum/{id}/update', 'ForumController@update')
    ->name('forum.update')
    ->middleware('role:admin,contentowner');

// Static

Route::get('{slug}', 'StaticController@show')
    ->name('static.show')
    ->where(
        'slug',
        '(' .
            collect(config('static.slugs'))
                ->keys()
                ->implode('|') .
            ')'
    );

Route::get('static/{id}', 'StaticController@showId')->name(
    'static.show.id'
);

Route::get('static/{id}/edit', 'StaticController@edit')
    ->name('static.edit')
    ->middleware('role:superuser');

Route::post('static/{id}/update', 'StaticController@update')
    ->name('static.update')
    ->middleware('role:superuser');

// Newsletter

Route::get('newsletter/list', 'NewsletterController@index')
    ->name('newsletter.index')
    ->middleware('role:superuser');

Route::get(
    'newsletter/view/{id}',
    'NewsletterController@view'
)
    ->name('newsletter.view')
    ->middleware('role:superuser');

Route::get(
    'newsletter/edit/{id}',
    'NewsletterController@edit'
)
    ->name('newsletter.edit')
    ->middleware('role:superuser');

Route::post(
    'newsletter/store/{id}',
    'NewsletterController@store'
)
    ->name('newsletter.store')
    ->middleware('role:superuser');

Route::get(
    'newsletter/preview/{id}',
    'NewsletterController@preview'
)
    ->name('newsletter.preview')
    ->middleware('role:superuser');

Route::get(
    'newsletter/preview_sent/{id}',
    'NewsletterController@preview_sent'
)
    ->name('newsletter.preview_sent')
    ->middleware('role:superuser');

Route::post(
    'newsletter/subscribe/{id}',
    'NewsletterController@subscribe'
)->name('newsletter.subscribe');

Route::get(
    'newsletter/unsubscribe/{hash}-{id}',
    'NewsletterController@unsubscribe'
)->name('newsletter.unsubscribe');

// Blog

Route::get('reisikirjad', 'BlogController@index')->name(
    'blog.index'
);

Route::get(
    'reisikirjad/{slug}',
    'BlogController@show'
)->name('blog.show');

Route::get('blog/create', 'BlogController@create')
    ->name('blog.create')
    ->middleware('role:regular');

Route::post('blog/store', 'BlogController@store')
    ->name('blog.store')
    ->middleware('role:regular');

Route::get('blog/{id}/edit', 'BlogController@edit')
    ->name('blog.edit')
    ->middleware('role:admin,contentowner');

Route::put('blog/{id}/update', 'BlogController@update')
    ->name('blog.update')
    ->middleware('role:admin,contentowner');

// Internal

Route::get('internal', 'InternalController@index')
    ->name('internal.index')
    ->middleware('role:admin');

Route::get('internal/{id}', 'InternalController@show')
    ->name('internal.show')
    ->middleware('role:admin');

Route::get('internal/create', 'InternalController@create')
    ->name('internal.create')
    ->middleware('role:admin');

Route::post('internal/store', 'InternalController@store')
    ->name('internal.store')
    ->middleware('role:admin');

Route::get('internal/{id}/edit', 'InternalController@edit')
    ->name('internal.edit')
    ->middleware('role:admin');

Route::post(
    'internal/{id}/update',
    'InternalController@update'
)
    ->name('internal.update')
    ->middleware('role:admin');

// Photo

Route::get('reisipildid', 'PhotoController@index')->name(
    'photo.index'
);

Route::get('photo/id/{id}', 'PhotoController@show')->name(
    'photo.show'
);

Route::get('photo/create', 'PhotoController@create')
    ->name('photo.create')
    ->middleware('role:regular');

Route::post('photo/store', 'PhotoController@store')
    ->name('photo.store')
    ->middleware('role:regular');

// Content redirects

Route::get(
    'content/{type}',
    'ContentController@redirectIndex'
)->name('content.index');

Route::get(
    'content/{type}/{id}',
    'ContentController@redirectShow'
)->name('content.show');

// Comments

Route::get('comment/{id}/edit', 'CommentController@edit')
    ->name('comment.edit')
    ->middleware('role:admin,commentowner');

// User

Route::get('user/{id}', 'UserController@show')->name(
    'user.show'
);

Route::get('user/{id}/edit', 'UserController@edit')
    ->name('user.edit')
    ->middleware('role:superuser,userowner');

Route::put('user/{id}/update', 'UserController@update')
    ->name('user.update')
    ->middleware('role:superuser,userowner');

Route::get(
    'user/{id}/destinations',
    'UserController@destinationsEdit'
)
    ->middleware('role:superuser,userowner')
    ->name('user.destinations.edit');

Route::put(
    'user/{id}/destinations',
    'UserController@destinationsStore'
)
    ->middleware('role:superuser,userowner')
    ->name('user.destinations.store');

// User photos

Route::get(
    'user/{id}/photo',
    'PhotoController@userIndex'
)->name('photo.user');

// Messages

Route::get('user/{id}/messages', 'MessageController@index')
    ->name('message.index')
    ->middleware('role:superuser,userowner');

Route::get(
    'user/{id}/messages/{id2}',
    'MessageController@indexWith'
)
    ->name('message.index.with')
    ->middleware('role:superuser,userowner');

Route::post(
    'message/{id}/to/{id2}',
    'MessageController@store'
)
    ->name('message.store')
    ->middleware('role:superuser,userowner');

// Follows

Route::get(
    'user/{id}/follows',
    'ForumController@followIndex'
)
    ->name('follow.index')
    ->middleware('role:admin,userowner');

Route::put(
    'content/{type}/{id}/follow/{status}',
    'FollowController@followContent'
)
    ->name('follow.follow.content')
    ->middleware('role:regular');

// Destination

Route::get(
    'sihtkoht/{id}',
    'DestinationController@show'
)->name('destination.show');

Route::get(
    'sihtkoht/{slug}',
    'DestinationController@showSlug'
)->name('destination.showSlug');

// Search

Route::get('search', 'SearchController@search')->name(
    'search.results'
);

Route::get(
    'search/ajaxsearch',
    'SearchController@ajaxsearch'
)->name('search.ajax');

Route::get(
    'search/{token}',
    'SearchController@search'
)->name('search.results.type');

// Image

Route::post('image', 'ImageController@store')
    ->name('image.store')
    ->middleware('role:regular');

// Destination

Route::get(
    'destination/{id}/edit',
    'DestinationController@edit'
)
    ->name('destination.edit')
    ->middleware('role:admin');
Route::post(
    'destination/{id}/update',
    'DestinationController@update'
)
    ->name('destination.update')
    ->middleware('role:admin');

// Admin

Route::get(
    'admin/content',
    'AdminController@unpublishedIndex'
)
    ->name('admin.content.index')
    ->middleware('role:admin');

Route::get('admin/image', 'AdminController@imageIndex')
    ->name('admin.image.index')
    ->middleware('role:admin');

Route::get('image/index', 'ImageController@index')
    ->name('image.index')
    ->middleware('role:admin');

Route::get('statistics', 'StatisticsController@index')
    ->name('statistics.index')
    ->middleware('role:superuser');

// Utils

Route::get('utils/alert', 'UtilsController@alert')->name(
    'utils.alert'
);

Route::get(
    'share/{social}',
    'SocialController@share'
)->name('utils.share');

Route::post('utils/filter', 'UtilsController@filter')->name(
    'utils.filter'
);

Route::post('utils/format', 'UtilsController@format')->name(
    'utils.format'
);

// Experiments

Route::get(
    'experiments',
    'ExperimentsController@index'
)->name('experiments.index');

Route::get(
    'experiments/select',
    'ExperimentsController@selectIndex'
)->name('experiments.select.index');

Route::post(
    'experiments/select',
    'ExperimentsController@selectCreate'
)->name('experiments.select.create');

Route::get(
    'experiments/fonts',
    'ExperimentsController@fontsIndex'
)->name('experiments.fonts.index');

Route::get(
    'experiments/map',
    'ExperimentsController@mapIndex'
)->name('experiments.map.index');

Route::get(
    'experiments/one',
    'ExperimentsLayoutController@indexOne'
)->name('experiments.layouts.one');

Route::get(
    'experiments/two',
    'ExperimentsLayoutController@indexTwo'
)->name('experiments.layouts.two');

Route::get(
    'experiments/grid',
    'ExperimentsLayoutController@indexGrid'
)->name('experiments.layouts.grid');

Route::get(
    'experiments/frontpage',
    'ExperimentsLayoutController@indexFrontpage'
)->name('experiments.layouts.frontpage');

Route::get(
    'experiments/list',
    'ExperimentsLayoutController@indexList'
)->name('experiments.layouts.list');

// Registration

Route::get('register', [
    'middleware' => 'guest',
    'uses' => 'Auth\RegistrationController@form',
    'as' => 'register.form'
]);

Route::post('register', [
    'middleware' => 'guest',
    'uses' => 'Auth\RegistrationController@submit',
    'as' => 'register.submit'
]);

Route::get('register/confirm/{token}', [
    'uses' => 'Auth\RegistrationController@confirm',
    'as' => 'register.confirm'
]);

// Login and logout

Route::get('login', [
    'middleware' => 'guest',
    'uses' => 'Auth\LoginController@form',
    'as' => 'login.form'
]);

Route::post('login', [
    'middleware' => 'guest',
    'uses' => 'Auth\LoginController@submit',
    'as' => 'login.submit'
]);

Route::get('logout', [
    'middleware' => 'auth',
    'uses' => 'Auth\LoginController@logout',
    'as' => 'login.logout'
]);

// Facebook login

Route::get('redirect/facebook', [
    'middleware' => 'guest',
    'uses' => 'SocialController@facebookRedirect',
    'as' => 'facebook.redirect'
]);

Route::get('facebook', [
    'uses' => 'SocialController@facebook',
    'as' => 'facebook'
]);

// Google+ login

Route::get('redirect/google', [
    'middleware' => 'guest',
    'uses' => 'SocialController@googleRedirect',
    'as' => 'google.redirect'
]);

Route::get('google', [
    'uses' => 'SocialController@google',
    'as' => 'google'
]);

// Password reset

Route::get('reset/apply', [
    'uses' => 'Auth\ResetController@applyForm',
    'as' => 'reset.apply.form'
]);

Route::post('reset/apply', [
    'uses' => 'Auth\ResetController@postEmail',
    'as' => 'reset.apply.submit'
]);

Route::get('reset/password/{token}', [
    'uses' => 'Auth\ResetController@passwordForm',
    'as' => 'reset.password.form'
]);

Route::post('reset/password', [
    'uses' => 'Auth\ResetController@reset',
    'as' => 'reset.password.submit'
]);

// Flags

Route::get(
    'flag/{flaggable_type}/{flaggable_id}/{flag_type}',
    [
        'middleware' => 'role:regular',
        'uses' => 'FlagController@toggle',
        'as' => 'flag.toggle'
    ]
);

// Comments

Route::post('content/{type}/{id}/comment', [
    'middleware' => 'role:regular',
    'uses' => 'CommentController@store',
    'as' => 'comment.store'
]);

Route::post('comment/{id}', [
    'middleware' => 'role:admin,commentowner',
    'uses' => 'CommentController@update',
    'as' => 'comment.update'
]);

Route::put('comment/{id}/status/{status}', [
    'middleware' => 'role:admin',
    'uses' => 'CommentController@status',
    'as' => 'comment.status'
]);

// Atom feeds

Route::get('index.atom', [
    'middleware' => 'throttle:60,1',
    'uses' => 'FeedController@newsFeed',
    'as' => 'news.feed'
]);

Route::get('lendude_sooduspakkumised/rss', [
    'middleware' => 'throttle:60,1',
    'uses' => 'FeedController@flightFeed',
    'as' => 'flight.feed'
]);

// Offers

Route::get('offers', 'OfferController@index')->middleware(
    'role:admin'
);

Route::get('style', 'StyleController@index');

// Legacy user paths

Route::get(
    'user/{id}/forum',
    'RedirectController@redirectUser'
);

Route::get(
    'sein/user/{id}',
    'RedirectController@redirectUser'
);

// Legacy term paths

Route::get(
    'taxonomy/term/{id}/{a?}',
    'RedirectController@redirectTaxonomy'
);

Route::get(
    'node/taxonomy/term/{id}',
    'RedirectController@redirectTaxonomy'
);

Route::get(
    'content/taxonomy/term/{id}',
    'RedirectController@redirectTaxonomy'
);

Route::get(
    'content/{blurb}/taxonomy/term/{id}',
    'RedirectController@redirectTaxonomyBlurb'
);

Route::get(
    'trip_destination/tid/{id}',
    'RedirectController@redirectTaxonomy'
);

Route::get(
    'sihtkoht/{title}',
    'RedirectController@redirectDestination'
);

Route::get(
    'content/{blurb}/sihtkoht/{title}',
    'RedirectController@redirectDestinationBlurb'
);

Route::get(
    'content/{blurb}/{blurb2}/sihtkoht/{title}',
    'RedirectController@redirectDestinationBlurb2'
);

Route::get(
    'node/sihtkoht/{title}',
    'RedirectController@redirectDestination'
);

Route::get(
    'content/sihtkoht/{title}',
    'RedirectController@redirectDestination'
);

Route::get(
    'category/{part1}/{part2}/{part3?}/{part4?}',
    'RedirectController@redirectCategory'
);

Route::get(
    'node/category/{part1}/{part2}/{part3?}/{part4?}',
    'RedirectController@redirectCategory'
);

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

Route::get(
    'node/view/{id}',
    'RedirectController@redirectNode'
);

Route::get(
    'node.php?id={id}',
    'RedirectController@redirectNode'
);

Route::get('blog/{id}', 'RedirectController@redirectNode');

Route::get(
    'content/news/{id}',
    'RedirectController@redirectNode'
);

Route::get(
    'sein/user/node/{id}',
    'RedirectController@redirectNode'
);

Route::get(
    'node/{id}/atom/feed',
    'RedirectController@redirectNode'
);

Route::get(
    'crss/node/{id}',
    'RedirectController@redirectNode'
);

Route::get(
    'content/{path}',
    'RedirectController@redirectContent'
)->where('path', '.*');

// All other legacy aliases

Route::get(
    '{part1}/{part2?}',
    'RedirectController@redirectAlias'
);
