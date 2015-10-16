<?php

return [

    'frontpage' => [

        'show' => true,
        'with' => [],
        'latest' => 'updated_at',
        'take' => 1,
    ],

    'index' => [

        'with' => ['user', 'comments', 'flags', 'destinations', 'topics'],
        'latest' => 'updated_at',
        'paginate' => 25,
    ],

    'edit' => [

        'fields' => [

            'title' => [
                'type' => 'text',
                'large' => true,
            ],
            'body' => [
                'type' => 'textarea',
            ],
            'destinations' => [
                'type' => 'destinations',
            ],
            'topics' => [
                'type' => 'topics',
            ],
            'submit' => [
                'type' => 'submit',
            ],
        ],

        'validate' => [

            'title' => 'required',
            'body' => 'required',

        ],

    ],

];
