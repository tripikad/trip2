<?php

use Illuminate\Support\Facades\Route;

// Frontpage

Route::get('/', 'FrontpageController@index')->name('frontpage.index');

// Content status

Route::post('content/{type}/{id}/status/{status}', 'ContentController@status')
    ->name('content.status')
    ->middleware('role:admin');

// News

Route::get('uudised', 'NewsController@index')->name('news.index');

Route::get('uudised/{slug}', 'NewsController@show')->name('news.show');

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

Route::get('luhiuudised', 'NewsController@shortnewsIndex')->name('shortnews.index');

Route::get('luhiuudised/{slug}', 'NewsController@show')->name('shortnews.show');

// Flight

Route::get('odavad-lennupiletid', 'FlightController@index')->name('flight.index');

Route::get('odavad-lennupiletid/{slug}', 'FlightController@show')->name('flight.show');

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

//flightcalendar API

Route::get('flightcalendar/month', 'FlightController@getMonthData')
    ->name('flightcalendar.month')
    ->middleware('throttle:60,1');

Route::get('flightcalendar/getLivePrice', 'FlightController@getLivePrice')
    ->name('flightcalendar.live_price')
    ->middleware('throttle:60,1');

// Travelmates

Route::get('reisikaaslased', 'TravelmateController@index')->name('travelmate.index');

Route::get('reisikaaslased/{slug}', 'TravelmateController@show')->name('travelmate.show');

Route::get('travelmate/create', 'TravelmateController@create')
    ->name('travelmate.create')
    ->middleware('role:regular');

Route::post('travelmate/store', 'TravelmateController@store')
    ->name('travelmate.store')
    ->middleware('role:regular');

Route::get('travelmate/{id}/edit', 'TravelmateController@edit')
    ->name('travelmate.edit')
    ->middleware('role:admin,contentowner');

Route::put('travelmate/{id}/update', 'TravelmateController@update')
    ->name('travelmate.update')
    ->middleware('role:admin,contentowner');

// Forum

Route::get('foorum/uldfoorum', 'ForumController@forumIndex')->name('forum.index');

Route::get('foorum/ost-muuk', 'ForumController@buysellIndex')->name('buysell.index');

Route::get('foorum/elu-valimaal', 'ForumController@expatIndex')->name('expat.index');

Route::get('foorum/vaba-teema', 'ForumController@miscIndex')->name('misc.index');

Route::get('foorum/uldfoorum/{slug}', 'ForumController@show')->name('forum.show');

Route::get('foorum/ost-muuk/{slug}', 'ForumController@show')->name('buysell.show');

Route::get('foorum/elu-valimaal/{slug}', 'ForumController@show')->name('expat.show');

Route::get('foorum/vaba-teema/{slug}', 'ForumController@show')->name('misc.show');

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

Route::get('static/{id}', 'StaticController@showId')->name('static.show.id');

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

Route::get('newsletter/view/{id}', 'NewsletterController@view')
    ->name('newsletter.view')
    ->middleware('role:superuser');

Route::get('newsletter/edit/{id}', 'NewsletterController@edit')
    ->name('newsletter.edit')
    ->middleware('role:superuser');

Route::post('newsletter/store/{id}', 'NewsletterController@store')
    ->name('newsletter.store')
    ->middleware('role:superuser');

Route::get('newsletter/preview/{id}', 'NewsletterController@preview')
    ->name('newsletter.preview')
    ->middleware('role:superuser');

Route::get('newsletter/preview_sent/{id}', 'NewsletterController@preview_sent')
    ->name('newsletter.preview_sent')
    ->middleware('role:superuser');

Route::post('newsletter/subscribe/{id}', 'NewsletterController@subscribe')->name('newsletter.subscribe');

Route::get('newsletter/unsubscribe/{hash}-{id}', 'NewsletterController@unsubscribe')->name('newsletter.unsubscribe');

// Blog

Route::get('reisikirjad', 'BlogController@index')->name('blog.index');

Route::get('reisikirjad/{slug}', 'BlogController@show')->name('blog.show');

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

Route::post('internal/{id}/update', 'InternalController@update')
    ->name('internal.update')
    ->middleware('role:admin');

// Photo

Route::get('reisipildid/{id?}', 'PhotoController@index')->name('photo.index');

Route::get('photo/id/{id}', 'PhotoController@show')->name('photo.show');

Route::get('photo/create', 'PhotoController@create')
    ->name('photo.create')
    ->middleware('role:regular');

Route::post('photo/store', 'PhotoController@store')
    ->name('photo.store')
    ->middleware('role:regular');

// Content redirects

Route::get('content/{type}', 'ContentController@redirectIndex')->name('content.index');

Route::get('content/{type}/{id}', 'ContentController@redirectShow')->name('content.show');

// Comments

Route::get('comment/{id}/edit', 'CommentController@edit')
    ->name('comment.edit')
    ->middleware('role:admin,commentowner');

// User

Route::get('user/{id}', 'UserController@show')->name('user.show');

Route::get('user/{id}/edit', 'UserController@edit')
    ->name('user.edit')
    ->middleware('role:superuser,userowner');

Route::put('user/{id}/update', 'UserController@update')
    ->name('user.update')
    ->middleware('role:superuser,userowner');

Route::get('user/{id}/destinations', 'UserController@destinationsEdit')
    ->middleware('role:superuser,userowner')
    ->name('user.destinations.edit');

Route::put('user/{id}/destinations', 'UserController@destinationsStore')
    ->middleware('role:superuser,userowner')
    ->name('user.destinations.store');

// User photos

Route::get('user/{id}/photo', 'PhotoController@userIndex')->name('photo.user');

// Messages

Route::get('user/{id}/messages', 'MessageController@index')
    ->name('message.index')
    ->middleware('role:superuser,userowner');

Route::get('user/{id}/messages/{id2}', 'MessageController@indexWith')
    ->name('message.index.with')
    ->middleware('role:superuser,userowner');

Route::post('message/{id}/to/{id2}', 'MessageController@store')
    ->name('message.store')
    ->middleware('role:superuser,userowner');

// Follows

Route::get('user/{id}/follows', 'ForumController@followIndex')
    ->name('follow.index')
    ->middleware('role:admin,userowner');

Route::put('content/{type}/{id}/follow/{status}', 'FollowController@followContent')
    ->name('follow.follow.content')
    ->middleware('role:regular');

// Destination

Route::get('sihtkoht/{id}', 'DestinationController@show')->name('destination.show');

Route::get('sihtkoht/{slug}', 'DestinationController@showSlug')->name('destination.showSlug');

Route::get('sihtkohad', 'DestinationController@index')->name('destination.index');
// Search

Route::get('search', 'SearchController@search')->name('search.results');

Route::get('search/ajaxsearch', 'SearchController@ajaxsearch')->name('search.ajax');

Route::get('search/{token}', 'SearchController@search')->name('search.results.type');

// Image

Route::post('image', 'ImageController@store')
    ->name('image.store')
    ->middleware('role:regular');

// Destination

Route::get('destination/{id}/edit', 'DestinationController@edit')
    ->name('destination.edit')
    ->middleware('role:admin');
Route::post('destination/{id}/update', 'DestinationController@update')
    ->name('destination.update')
    ->middleware('role:admin');

// Admin

Route::get('admin/content', 'AdminController@unpublishedIndex')
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

Route::get('utils/alert', 'UtilsController@alert')->name('utils.alert');

Route::get('share/{social}', 'SocialController@share')->name('utils.share');

Route::post('utils/filter', 'UtilsController@filter')->name('utils.filter');

Route::post('utils/format', 'UtilsController@format')->name('utils.format');

// Style guides

Route::get('styleguide', 'Styleguide\StyleguideController@index')->name('styleguide.index');

Route::get('styleguide/colors', 'Styleguide\ColorsController@index')->name('styleguide.colors.index');

Route::get('styleguide/fonts', 'Styleguide\FontsController@index')->name('styleguide.fonts.index');

Route::get('styleguide/icons', 'Styleguide\IconsController@index')->name('styleguide.icons.index');

Route::get('styleguide/grid', 'Styleguide\GridController@index')->name('styleguide.grid.index');

Route::get('styleguide/components', 'Styleguide\ComponentsController@index')->name('styleguide.components.index');

// Experiments

Route::get('experiments/{id?}', 'ExperimentsController@index')->name('experiments.index');

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

Route::get('register_company', [
    'middleware' => 'guest',
    'uses' => 'Auth\RegistrationController@companyForm',
    'as' => 'register_company.form'
]);

Route::post('register_company', [
    'middleware' => 'guest',
    'uses' => 'Auth\RegistrationController@submitCompanyForm',
    'as' => 'register_company.submit'
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

Route::get('flag/{flaggable_type}/{flaggable_id}/{flag_type}', [
    'middleware' => 'role:regular',
    'uses' => 'FlagController@toggle',
    'as' => 'flag.toggle'
]);

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

// Companies

Route::get('firma/{slug}', 'CompanyController@profilePublic')
    ->name('company.profile.public');

Route::get('firma/{slug}/pakkumised', 'CompanyController@offersPublic')
    ->name('company.offers.public');

Route::get('company/{company}', 'CompanyController@profile')
    ->name('company.profile')
    ->middleware('companyOwner');

Route::get('company/{company}/edit_profile', 'CompanyController@editProfile')
    ->name('company.edit_profile')
    ->middleware('companyOwner');

Route::post('company/{company}/update_profile', 'CompanyController@updateProfile')
    ->name('company.update_profile')
    ->middleware('companyOwner');

Route::get('company/{company}/add_travel_offer', 'CompanyController@addTravelOffer')
    ->name('company.add_travel_offer')
    ->middleware('companyOwner');

Route::post('company/{company}/store_travel_offer', 'CompanyController@storeTravelOffer')
    ->name('company.store_travel_offer')
    ->middleware('companyOwner');

Route::get('company/{company}/travel_offer/{travelOffer}/edit', 'CompanyController@editTravelOffer')
    ->name('company.edit_travel_offer')
    ->middleware('companyOwner');

Route::post('company/{company}/travel_offer/{travelOffer}/update', 'CompanyController@updateTravelOffer')
    ->name('company.update_travel_offer')
    ->middleware('companyOwner');


/*Route::get('company', 'CompanyController@index')
    ->name('company.index')
    ->middleware('company');

Route::get('company/admin', 'CompanyController@adminIndex')
    ->name('company.admin.index')
    ->middleware('role:superuser');

Route::get('company/{id}', 'CompanyController@show')->name('company.show');

Route::get('company/create', 'CompanyController@create')
    ->name('company.create')
    ->middleware('role:superuser');

Route::post('company/store', 'CompanyController@store')
    ->name('company.store')
    ->middleware('role:superuser');

Route::get('company/{id}/edit', 'CompanyController@edit')
    ->name('company.edit')
    ->middleware('role:superuser,userowner')
    ->middleware('company');

Route::put('company/{id}/update', 'CompanyController@update')
    ->name('company.update')
    ->middleware('role:superuser,userowner')
    ->middleware('company');*/

// Travel offers

Route::get('reisipakkumised', 'TravelOfferController@index')->name('travel_offer.index');

//travel packages

Route::get('reisipakkumised/reisipaketid', 'TravelPackageController@index')->name('travel_offer.travel_package.index');

Route::get('reisipakkumised/reisipaketid/{slug}', 'TravelPackageController@show')->name('travel_offer.travel_package.show');

//ski packages

//Route::get('reisipakkumised/suusareisid', 'SkiTripController@show')->name('travel_offer.ski_package.show');
//Route::get('reisipakkumised/suusareisid/{slug}', 'TravelSkiTripControllerOfferController@show')->name('travel_offer.ski_package.show');


// Offers

Route::get('reisipakkumised2', 'OfferController@index')->name('offer.index');

Route::get('reisipakkumised2/{id}', 'OfferController@show')->name('offer.show');

Route::get('offer/json', 'OfferController@indexJson')->name('offer.index.json');

// Offers admin

Route::get('offer/admin/create/{style}', 'OfferAdminController@create')
    ->name('offer.admin.create')
    ->middleware('company')
    ->where('style', '(' . collect(config('offer.styles'))->implode('|') . ')');

Route::post('offer/admin/store', 'OfferAdminController@store')
    ->name('offer.admin.store')
    ->middleware('company');

Route::get('offer/{id}/edit', 'OfferAdminController@edit')
    ->name('offer.admin.edit')
    ->middleware('company');

Route::put('offer/{id}/update', 'OfferAdminController@update')
    ->name('offer.admin.update')
    ->middleware('company');

// Bookings

Route::post('booking/{id}', 'BookingController@create')
    // @LAUNCH remove this control
    ->middleware('role:superuser')
    ->name('booking.create');

Route::get('booking/{id}/goto', 'BookingController@goto')->name('booking.goto');

// Polls

Route::get('polls', 'PollController@index')
    ->name('poll.index')
    ->middleware('role:admin');

Route::get('poll/create', 'PollController@create')
    ->name('poll.create')
    ->middleware('role:admin');

Route::post('poll/store', 'PollController@store')
    ->name('poll.store')
    ->middleware('role:admin');

Route::get('poll/{poll}/edit', 'PollController@edit')
    ->name('poll.edit')
    ->middleware('role:admin');

Route::post('poll/{poll}/update', 'PollController@update')
    ->name('poll.update')
    ->middleware('role:admin');

Route::get('poll/{poll}/show', 'PollController@show')
    ->name('poll.show')
    ->middleware('role:admin');

Route::post('poll/{poll}/delete', 'PollController@delete')
    ->name('poll.delete')
    ->middleware('role:admin');

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

Route::get('content/{blurb}/sihtkoht/{title}', 'RedirectController@redirectDestinationBlurb');

Route::get('content/{blurb}/{blurb2}/sihtkoht/{title}', 'RedirectController@redirectDestinationBlurb2');

Route::get('node/sihtkoht/{title}', 'RedirectController@redirectDestination');

Route::get('content/sihtkoht/{title}', 'RedirectController@redirectDestination');

Route::get('category/{part1}/{part2}/{part3?}/{part4?}', 'RedirectController@redirectCategory');

Route::get('node/category/{part1}/{part2}/{part3?}/{part4?}', 'RedirectController@redirectCategory');

Route::get('content/category/{part1}/{part2}/{part3?}/{part4?}', 'RedirectController@redirectCategory');

Route::get('content/{blurb}/category/{part1}/{part2}/{part3?}/{part4?}', 'RedirectController@redirectCategoryBlurb');

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

Route::get('content/{path}', 'RedirectController@redirectContent')->where('path', '.*');

// All other legacy aliases

Route::get('{part1}/{part2?}', 'RedirectController@redirectAlias');
