<?php

return [

    'frontpage' => [
        
        'show' => true,
        'paginate' => 4
    ],

    'index' => [
    
        'with' => ['user', 'destinations'],
        'latest' => 'created_at',
        'paginate' => 24,
    ],

    'edit' => [

        'fields' => [
            'file' => [
                'type' => 'file',
            ],
            'title' => [
                'type' => 'text',
                'title' => 'Offer description',
                'rows' => 2
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