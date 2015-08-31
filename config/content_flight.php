<?php

return [

    'frontpage' => [
        
        'show' => true,
        'with' => [],
        'latest' => 'created_at',
        'take' => 8
    ],

    'index' => [
    
        'with' => ['destinations', 'carriers'],
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
            'url' => [
                'type' => 'url',
                'title' => 'URL',
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Add',
            ]
        ],

        'validate' => [
        
            'title' => 'required',
            'url' => 'url',
        
        ],

    ]

];