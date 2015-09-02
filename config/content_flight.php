<?php

return [

    'frontpage' => [
        
        'show' => true,
        'with' => ['images'],
        'latest' => 'created_at',
        'take' => 8
    ],

    'index' => [
    
        'with' => ['images'],
        'latest' => 'created_at',
        'paginate' => 24,
    ],

    'edit' => [

        'fields' => [
            'title' => [
                'type' => 'text',
            ],
            'body' => [
                'type' => 'textarea',
            ],
            'url' => [
                'type' => 'url',
            ],
            'submit' => [
                'type' => 'submit',
            ]
        ],

        'validate' => [
        
            'title' => 'required',
            'url' => 'url',
        
        ],

    ]

];