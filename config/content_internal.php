<?php

return [

    'view' => [
        'index' => 'pages.content.forum.index',
        'show' => 'pages.content.forum.show',
    ],

    'menu' => 'admin',

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
                'large' => true,
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Add',
            ],
        ],

        'validate' => [

            'title' => 'required',
            'body' => 'required',

        ],

    ],

];
