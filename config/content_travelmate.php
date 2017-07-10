<?php

return [

    'index' => [

        'with' => ['user', 'destinations', 'topics'],
        'orderBy' => [
            'field' => 'created_at',
            'order' => 'desc',
        ],
        'expire' => [
            'field' => 'start_at',
            'daysFrom' => 'start_at',
            'daysTo' => -30,
            'type' => 'datetime',
        ],
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
            'body' => 'required',
            'start_at' => 'date|required',

        ],

    ],

];
