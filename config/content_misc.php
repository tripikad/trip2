<?php

return [

    'view' => [
        'index' => 'pages.content.forum.index',
        'show' => 'pages.content.forum.show',
    ],

    'menu' => 'forum',

    'index' => [

        'with' => ['user', 'comments', 'flags'],
        'orderBy' => [
            'field' => 'updated_at',
            'order' => 'desc',
        ],
        'paginate' => 35,
    ],

    'edit' => [

        'fields' => [
            'type' => [
                'type' => 'radio',
                'items' => 'menu.forum',
            ],
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
