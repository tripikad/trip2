<?php

return [

    'view' => [
        'index' => 'pages.content.forum.index',
        'show' => 'pages.content.forum.show',
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
