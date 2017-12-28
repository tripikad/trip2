<?php


// Frontpage

Route::get('/', 'V2FrontpageController@index')
    ->name('frontpage.index');

// Content status

Route::post('content/{type}/{id}/status/{status}', 'V2ContentController@status')
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

// Shortnews

Route::get('luhiuudised', 'V2NewsController@shortnewsIndex')
    ->name('shortnews.index');

Route::get('luhiuudised/{slug}', 'V2NewsController@show')
    ->name('shortnews.show');

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

Route::get('foorum/vaba-teema', 'V2ForumController@miscIndex')
    ->name('misc.index');

Route::get('foorum/uldfoorum/{slug}', 'V2ForumController@show')
    ->name('forum.show');

Route::get('foorum/ost-muuk/{slug}', 'V2ForumController@show')
    ->name('buysell.show');

Route::get('foorum/elu-valimaal/{slug}', 'V2ForumController@show')
    ->name('expat.show');

Route::get('foorum/vaba-teema/{slug}', 'V2ForumController@show')
    ->name('misc.show');

Route::get('forum/create/{type}', 'V2ForumController@create')
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

Route::get('{slug}', 'V2StaticController@show')
    ->name('static.show')
    ->where(
        'slug',
        '('.collect(config('static.slugs'))->keys()->implode('|').')'
    );

Route::get('static/{id}', 'V2StaticController@showId')
    ->name('static.show.id');

Route::get('static/{id}/edit', 'V2StaticController@edit')
    ->name('static.edit')
    ->middleware('role:superuser');

Route::post('static/{id}/update', 'V2StaticController@update')
    ->name('static.update')
    ->middleware('role:superuser');

// Newsletter

Route::get('newsletter/list', 'V2NewsletterController@index')
    ->name('newsletter.index')
    ->middleware('role:superuser');

Route::get('newsletter/view/{id}', 'V2NewsletterController@view')
    ->name('newsletter.view')
    ->middleware('role:superuser');

Route::get('newsletter/edit/{id}', 'V2NewsletterController@edit')
    ->name('newsletter.edit')
    ->middleware('role:superuser');

Route::post('newsletter/store/{id}', 'V2NewsletterController@store')
    ->name('newsletter.store')
    ->middleware('role:superuser');

Route::get('newsletter/preview/{id}', 'V2NewsletterController@preview')
    ->name('newsletter.preview')
    ->middleware('role:superuser');

Route::get('newsletter/preview_sent/{id}', 'V2NewsletterController@preview_sent')
    ->name('newsletter.preview_sent')
    ->middleware('role:superuser');

Route::post('newsletter/subscribe/{id}', 'V2NewsletterController@subscribe')
    ->name('newsletter.subscribe');

Route::get('newsletter/unsubscribe/{hash}-{id}', 'V2NewsletterController@unsubscribe')
    ->name('newsletter.unsubscribe');

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

Route::put('blog/{id}/update', 'V2BlogController@update')
    ->name('blog.update')
    ->middleware('role:admin,contentowner');

// Internal

Route::get('internal', 'V2InternalController@index')
    ->name('internal.index')
    ->middleware('role:admin');

Route::get('internal/{id}', 'V2InternalController@show')
    ->name('internal.show')
    ->middleware('role:admin');

Route::get('internal/create', 'V2InternalController@create')
    ->name('internal.create')
    ->middleware('role:admin');

Route::post('internal/store', 'V2InternalController@store')
    ->name('internal.store')
    ->middleware('role:admin');

Route::get('internal/{id}/edit', 'V2InternalController@edit')
    ->name('internal.edit')
    ->middleware('role:admin');

Route::post('internal/{id}/update', 'V2InternalController@update')
    ->name('internal.update')
    ->middleware('role:admin');

// Photo

Route::get('reisipildid', 'V2PhotoController@index')
    ->name('photo.index');

Route::get('photo/id/{id}', 'V2PhotoController@show')
    ->name('photo.show');

Route::get('photo/create', 'V2PhotoController@create')
    ->name('photo.create')
    ->middleware('role:regular');

Route::post('photo/store', 'V2PhotoController@store')
    ->name('photo.store')
    ->middleware('role:regular');

// Content redirects

Route::get('content/{type}', 'V2ContentController@redirectIndex')
    ->name('content.index');

Route::get('content/{type}/{id}', 'V2ContentController@redirectShow')
    ->name('content.show');

// Comments

Route::get('comment/{id}/edit', 'V2CommentController@edit')
    ->name('comment.edit')
    ->middleware('role:admin,commentowner');

// User

Route::get('user/{id}', 'V2UserController@show')
    ->name('user.show');

Route::get('user/{id}/edit', 'V2UserController@edit')
    ->name('user.edit')
    ->middleware('role:superuser,userowner');

Route::put('user/{id}/update', 'V2UserController@update')
    ->name('user.update')
    ->middleware('role:superuser,userowner');

Route::get('user/{id}/destinations', 'V2UserController@destinationsEdit')
    ->middleware('role:superuser,userowner')
    ->name('user.destinations.edit');

Route::put('user/{id}/destinations', 'V2UserController@destinationsStore')
    ->middleware('role:superuser,userowner')
    ->name('user.destinations.store');

// User photos

Route::get('user/{id}/photo', 'V2PhotoController@userIndex')
    ->name('photo.user');

// Messages

Route::get('user/{id}/messages', 'V2MessageController@index')
    ->name('message.index')
    ->middleware('role:superuser,userowner');

Route::get('user/{id}/messages/{id2}', 'V2MessageController@indexWith')
    ->name('message.index.with')
    ->middleware('role:superuser,userowner');

Route::post('message/{id}/to/{id2}', 'V2MessageController@store')
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

Route::get('sihtkoht/{id}', 'V2DestinationController@show')
    ->name('destination.show');

Route::get('sihtkoht/{slug}', 'V2DestinationController@showSlug')
    ->name('destination.showSlug');

// Search

Route::get('search', 'V2SearchController@search')
    ->name('search.results');

Route::get('search/ajaxsearch', 'V2SearchController@ajaxsearch')
    ->name('search.ajax');

Route::get('search/{token}', 'V2SearchController@search')
    ->name('search.results.type');

// Image

Route::post('image', 'V2ImageController@store')
    ->name('image.store')
    ->middleware('role:regular');

// Destination

Route::get('destination/{id}/edit', 'V2DestinationController@edit')
    ->name('destination.edit')
    ->middleware('role:admin');
Route::post('destination/{id}/update', 'V2DestinationController@update')
    ->name('destination.update')
    ->middleware('role:admin');

// Admin

Route::get('admin/content', 'V2AdminController@unpublishedIndex')
    ->name('admin.content.index')
    ->middleware('role:admin');

Route::get('admin/image', 'V2AdminController@imageIndex')
    ->name('admin.image.index')
    ->middleware('role:admin');

Route::get('image/index', 'V2ImageController@index')
    ->name('image.index')
    ->middleware('role:admin');

Route::get('statistics', 'V2StatisticsController@index')
    ->name('statistics.index')
    ->middleware('role:superuser');

// Utils

Route::get('utils/alert', 'V2UtilsController@alert')
    ->name('utils.alert');

Route::get('share/{social}', 'V2SocialController@share')
    ->name('utils.share');

Route::post('utils/filter', 'V2UtilsController@filter')
    ->name('utils.filter');

Route::post('utils/format', 'V2UtilsController@format')
    ->name('utils.format');

// Experiments

Route::get('experiments', 'V2ExperimentsController@index')
    ->name('experiments.index');

Route::get('experiments/select', 'V2ExperimentsController@selectIndex')
    ->name('experiments.select.index');

Route::post('experiments/select', 'V2ExperimentsController@selectCreate')
    ->name('experiments.select.create');

Route::get('experiments/fonts', 'V2ExperimentsController@fontsIndex')
    ->name('experiments.fonts.index');

Route::get('experiments/map', 'V2ExperimentsController@mapIndex')
    ->name('experiments.map.index');

Route::get('experiments/similars', 'V2ExperimentsSimilarsController@index')
    ->name('experiments.similars')
    ->middleware('role:admin');

Route::get('experiments/one', 'V2ExperimentsLayoutController@indexOne')
    ->name('experiments.layouts.one');

Route::get('experiments/two', 'V2ExperimentsLayoutController@indexTwo')
    ->name('experiments.layouts.two');

Route::get('experiments/grid', 'V2ExperimentsLayoutController@indexGrid')
    ->name('experiments.layouts.grid');

Route::get('experiments/frontpage', 'V2ExperimentsLayoutController@indexFrontpage')
    ->name('experiments.layouts.frontpage');

// V1

// Registration

Route::get('register', ['middleware' => 'guest', 'uses' => 'Auth\RegistrationController@form', 'as' => 'register.form']);

Route::post('register', ['middleware' => 'guest', 'uses' => 'Auth\RegistrationController@submit', 'as' => 'register.submit']);

Route::get('register/confirm/{token}', ['uses' => 'Auth\RegistrationController@confirm', 'as' => 'register.confirm']);

// Login and logout

Route::get('login', ['middleware' => 'guest', 'uses' => 'Auth\LoginController@form', 'as' => 'login.form']);

Route::post('login', ['middleware' => 'guest', 'uses' => 'Auth\LoginController@submit', 'as' => 'login.submit']);

Route::get('logout', ['middleware' => 'auth', 'uses' => 'Auth\LoginController@logout', 'as' => 'login.logout']);

// Facebook login

Route::get('redirect/facebook', ['middleware' => 'guest', 'uses' => 'V2SocialController@facebookRedirect', 'as' => 'facebook.redirect']);

Route::get('facebook', ['uses' => 'V2SocialController@facebook', 'as' => 'facebook']);

// Google+ login

Route::get('redirect/google', ['middleware' => 'guest', 'uses' => 'V2SocialController@googleRedirect', 'as' => 'google.redirect']);

Route::get('google', ['uses' => 'V2SocialController@google', 'as' => 'google']);

// Password reset

Route::get('reset/apply', ['uses' => 'Auth\ResetController@applyForm', 'as' => 'reset.apply.form']);

Route::post('reset/apply', ['uses' => 'Auth\ResetController@postEmail', 'as' => 'reset.apply.submit']);

Route::get('reset/password/{token}', ['uses' => 'Auth\ResetController@passwordForm', 'as' => 'reset.password.form']);

Route::post('reset/password', ['uses' => 'Auth\ResetController@reset', 'as' => 'reset.password.submit']);

// Flags

Route::get('flag/{flaggable_type}/{flaggable_id}/{flag_type}', ['middleware' => 'role:regular', 'uses' => 'FlagController@toggle', 'as' => 'flag.toggle']);

// Comments

Route::post('content/{type}/{id}/comment', ['middleware' => 'role:regular', 'uses' => 'V2CommentController@store', 'as' => 'comment.store']);

Route::post('comment/{id}', ['middleware' => 'role:admin,commentowner', 'uses' => 'V2CommentController@update', 'as' => 'comment.update']);

Route::put('comment/{id}/status/{status}', ['middleware' => 'role:admin', 'uses' => 'V2CommentController@status', 'as' => 'comment.status']);

// Atom feeds

Route::get('index.atom', ['middleware' => 'throttle:60,1', 'uses' => 'FeedController@newsFeed', 'as' => 'news.feed']);

Route::get('lendude_sooduspakkumised/rss', ['middleware' => 'throttle:60,1', 'uses' => 'FeedController@flightFeed', 'as' => 'flight.feed']);

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
