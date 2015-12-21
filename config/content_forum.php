<?php

return [

    'index' => [

        'with' => ['user', 'comments', 'flags', 'destinations', 'topics'],
        'orderBy' => [
            'field' => 'updated_at',
            'order' => 'desc',
        ],
        'paginate' => 25,
    ],

    'menu' => 'forum',

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
