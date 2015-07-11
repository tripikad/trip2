<?php

return [


    'types' => [

        'news' => [
    
            'title' => 'News',
            'with' => ['destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => '24',
            'edit' => [
                'title' => 'Add news',
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Title',
                    ],
                    'url' => [
                        'type' => 'url',
                        'title' => 'URL',
                    ],
                    'image' => [
                        'type' => 'text',
                        'title' => 'Image',
                    ],
                    'body' => [
                        'type' => 'textarea',
                        'title' => 'Body',
                    ],
                    'submit' => [
                        'type' => 'submit',
                        'title' => 'Add',
                    ]
                ]
            ],
            'front' => true,
            'frontpaginate' => 3,
    
        ],

        'flight' => [
    
            'title' => 'Flights',
            'with' => ['destinations', 'carriers'],
            'latest' => 'created_at',
            'paginate' => '24',
            'front' => true,
            'frontpaginate' => 4    
        ],

        'travelmate' => [
    
            'title' => 'Travelmates',
            'with' => ['user', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => 24,
            'front' => true,
            'frontpaginate' => 4    
        ],

        'forum' => [
    
            'edit' => [
                'title' => 'Add forum',
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'title' => 'Title',
                    ],
                    'body' => [
                        'type' => 'textarea',
                        'title' => 'Body',
                    ],
                    'submit' => [
                        'type' => 'submit',
                        'title' => 'Add',
                    ]
                ]
            ],
            'title' => 'Forum',
            'with' => ['user', 'comments', 'flags', 'destinations', 'topics'],
            'latest' => 'updated_at',
            'paginate' => 25,
            'front' => true,
            'frontpaginate' => 6       
        ],

        'photo' => [
        
            'title' => 'Images',
            'with' => ['user', 'destinations'],
            'latest' => 'created_at',
            'paginate' => '24',
            'front' => true,
            'frontpaginate' => 3       
        ],

        'blog' => [
    
            'title' => 'Blogs',
            'with' => ['user', 'comments', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => 25,
            'front' => true,
            'frontpaginate' => 4    
        ],

        'offer' => [
        
            'title' => 'Offers',
            'with' => ['user', 'destinations'],
            'latest' => 'created_at',
            'paginate' => '24',
            'front' => true,
            'frontpaginate' => 4         
        ],

        'internal' => [
        
            'title' => '...',
            'with' => ['user', 'destinations', 'topics'],
            'latest' => 'created_at',
            'paginate' => 25
        
        ]
    ],

    'allowed' => '(forum|blog|travelmate|news|flight|photo|offer|internal)'

];