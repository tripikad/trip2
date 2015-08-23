<?php

return [

    'frontpage' => [
        
        'show' => true,
        'paginate' => 3
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
                'type' => 'textarea',
                'title' => 'Description',
                'rows' => 2
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Add',
            ]
        ],

        'validate' => [
        
            'title' => 'required',
            'file' => 'required|image'
        
        ],

    ]

];