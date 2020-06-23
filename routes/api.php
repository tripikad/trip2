<?php

Route::get('destinations', 'ApiController@destinations');

Route::get('destinations/data', 'ApiController@destinationsData');

Route::get('flights', 'ApiController@flights');

Route::get('countrydots', 'ApiController@countrydots');

Route::get('airports', 'ApiController@airports');

$this->namespace('Api')->group(function () {
    Route::middleware('throttle:60,1')->group(function () {
        Route::prefix('/poll')
            ->group(function () {
                $this->get('/front_page', 'PollController@getFrontPagePoll');
                $this->get('/{poll}', 'PollController@getPoll');
                $this->post('/{poll}/answer', 'PollController@answer');
            });
    });
});
