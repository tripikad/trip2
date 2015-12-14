<?php

return [

    'index' => [

        'with' => ['user', 'comments', 'destinations', 'topics'],
        'orderBy' => [
            'field' => 'created_at',
            'order' => 'desc',
        ],
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
            'url' => [
                'type' => 'url',
            ],
            'submit' => [
                'type' => 'submit',
            ],
        ],

        'validate' => [

            'title' => 'required',
            'url' => 'url',

        ],

    ],

];
