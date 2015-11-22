<?php

return [

    'frontpage' => [

        'show' => true,
        'with' => ['user'],
        'latest' => 'created_at',
        'take' => 8,
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
            ],
            'body' => [
                'type' => 'textarea',
                'large' => true,
            ],
            'destinations' => [
                'type' => 'destinations',
            ],
            'topics' => [
                'type' => 'topics',
            ],
            'start_at' => [
                'type' => 'datetime',
                'help' => true,
            ],
            'duration' => [
                'type' => 'text',
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Add',
            ],
        ],

        'validate' => [

            'title' => 'required',
            'start_at' => 'date|required',

        ],

    ],

];
