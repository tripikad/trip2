<?php

return [

    'frontpage' => [

        'show' => false,
        'with' => [],
        'latest' => 'created_at',
        'take' => 4,

    ],

    'index' => [

        'with' => ['destinations', 'topics'],
        'latest' => 'created_at',
        'paginate' => 24,
    ],

    'store' => [

        'status' => 1,

    ],

    'edit' => [

        'fields' => [
            'title' => [
                'type' => 'textarea',
                'rows' => 3,
                'large' => true,
            ],
            'body' => [
                'type' => 'textarea',
                'rows' => 2,
            ],
            'destinations' => [
                'type' => 'destinations',
            ],
            'topics' => [
                'type' => 'topics',
            ],
            'url' => [
                'type' => 'url',
                'title' => 'URL',
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Add',
            ],
        ],

        'validate' => [

            'title' => 'required',
            'url' => 'url',
            'file' => 'image',

        ],

    ],

];
