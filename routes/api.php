<?php

use Illuminate\Support\Facades\Route;

Route::get('destinations', 'ApiController@destinations');

Route::get('destinations/data', 'ApiController@destinationsData');

Route::get('flights', 'ApiController@flights');

Route::get('countrydots', 'ApiController@countrydots');

Route::get('airports', 'ApiController@airports');

Route::namespace('Api')->group(function () {
    Route::middleware('throttle:60,1')->group(function () {
        Route::prefix('/poll')->group(function () {
            Route::get('/front_page', 'PollController@getFrontPagePoll');
            Route::get('/{poll}', 'PollController@getPoll');
            Route::post('/{poll}/answer', 'PollController@answer');
        });
    });
});
