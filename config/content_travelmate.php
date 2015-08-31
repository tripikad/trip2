<?php

return [

    'frontpage' => [
        
        'show' => true,
        'with' => ['user'],
        'latest' => 'created_at',
        'take' => 8
    ],

    'index' => [
    
        'with' => ['user', 'destinations', 'topics'],
        'latest' => 'created_at',
        'paginate' => 24,
    ],

    'edit' => [

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
        ],

        'validate' => [
        
            'title' => 'required',
            'body' => 'required',
        
        ],

    ]

];