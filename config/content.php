<?php

return [


    'types' => [

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

        'travelmate' => [
    
            'title' => 'Travelmates',
            'with' => ['user', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => '24'
    
        ],

        'forum' => [
    
            'title' => 'Forum',
            'with' => ['user', 'comments', 'flags', 'destinations', 'topics'],
            'latest' => 'updated_at',
            'paginate' => '25'
    
        ],

        'photo' => [
        
            'title' => 'Images',
            'with' => ['user', 'destinations'],
            'latest' => 'created_at',
            'paginate' => '24'
        
        ],

        'blog' => [
    
            'title' => 'Blogs',
            'with' => ['user', 'comments', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => '25'
    
        ],

        'offer' => [
        
            'title' => 'Offers',
            'with' => ['user', 'destinations'],
            'latest' => 'created_at',
            'paginate' => '24'
        
        ],

        'internal' => [
        
            'title' => 'Internal forum',
            'with' => ['user', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => '25'
        
        ]
    ],

    'allowed' => '(forum|blog|travelmate|news|flight|photo|offer|internal)'

];