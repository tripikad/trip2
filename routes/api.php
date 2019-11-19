<?php

Route::get('destinations', 'ApiController@destinations');

Route::get('destinations/data', 'ApiController@destinationsData');

Route::get('flights', 'ApiController@flights');

Route::get('countrydots', 'ApiController@countrydots');

Route::get('airports', 'ApiController@airports');
