<?php

return [


    'types' => [

        'forum' => [
    
            'title' => 'Forum',
            'with' => ['user', 'comments', 'flags', 'destinations', 'topics'],
            'latest' => 'updated_at',
            'paginate' => '25'
    
        ],

        'blog' => [
    
            'title' => 'Blogs',
            'with' => ['user', 'comments', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => '25'
    
        ],

        'travelmate' => [
    
            'title' => 'Travelmates',
            'with' => ['user', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => '24'
    
        ],

        'news' => [
    
            'title' => 'News',
            'with' => ['destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => '24'
    
        ],

        'flight' => [
    
            'title' => 'Flights',
            'with' => ['destinations', 'carriers'],
            'latest' => 'created_at',
            'paginate' => '24'
    
        ],

        'photo' => [
        
            'title' => 'Images',
            'with' => ['user', 'destinations'],
            'latest' => 'created_at',
            'paginate' => '24'
        
        ],

        'offer' => [
        
            'title' => 'Offers',
            'with' => ['user', 'destinations'],
            'latest' => 'created_at',
            'paginate' => '24'
        
        ]

    ],

    'allowed' => '(forum|blog|travelmate|news|flight|photo|offer)'

];