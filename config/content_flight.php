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
        'latest' => 'end_at',
        'paginate' => 24,
    ],

    'edit' => [

        'fields' => [
            'title' => [
                'type' => 'text',
            ],
            'body' => [
                'type' => 'textarea',
                'rows' => 16,
            ],
            'destinations' => [
                'type' => 'destinations',
            ],
            'start_at' => [
                'type' => 'datetime',
            ],
            'end_at' => [
                'type' => 'datetime',
            ],
            'price' => [
                'type' => 'currency',
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
            'start_at' => 'date',
            'end_at' => 'date',
            'price' => 'integer',
        
        ],

    ]

];