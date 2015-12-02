<?php

return [

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
            ],
            'body' => [
                'type' => 'textarea',
                'rows' => 2,
                'large' => true,
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
