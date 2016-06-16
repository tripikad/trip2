<?php

return [

    'index' => [

        'with' => ['user', 'comments', 'flags', 'destinations', 'topics'],
        'orderBy' => [
            'field' => 'updated_at',
            'order' => 'desc',
        ],
        'paginate' => 35,
    ],

    'menu' => 'forum',

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
