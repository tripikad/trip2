<?php

return [


    'types' => [

        'forum' => [
    
            'title' => 'Forum',
            'with' => ['user', 'comments', 'flags'],
            'latest' => 'updated_at',
            'paginate' => '25'
    
        ],

        'blog' => [
    
            'title' => 'Blogs',
            'with' => ['user', 'comments'],
            'latest' => 'created_at',
            'paginate' => '25'
    
        ],

        'travelmate' => [
    
            'title' => 'Travelmates',
            'with' => ['user'],
            'latest' => 'created_at',
            'paginate' => '24'
    
        ],

        'news' => [
    
            'title' => 'News',
            'with' => [],
            'latest' => 'created_at',
            'paginate' => '24'
    
        ],

        'flight' => [
    
            'title' => 'Flights',
            'with' => [],
            'latest' => 'created_at',
            'paginate' => '24'
    
        ]
    ],

    'allowed' => '(forum|blog|travelmate|news|flight)'

];