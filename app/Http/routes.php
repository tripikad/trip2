<?php

get('content/index/{type}', 'ContentController@index')
    ->where([
        'type' => config('content.allowed')
]);

get('content/{id}', 'ContentController@show');
