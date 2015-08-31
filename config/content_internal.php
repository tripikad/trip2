<?php

return [

    'index' => [
    
        'with' => ['user', 'destinations', 'topics'],
        'latest' => 'updated_at',
        'paginate' => 25,
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