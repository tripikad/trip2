<?php

return [

    'index' => [

        'with' => ['user', 'destinations'],
        'orderBy' => [
            'field' => 'created_at',
            'order' => 'desc',
        ],
        'paginate' => 24,
    ],

    'edit' => [

        'fields' => [
            'file' => [
                'type' => 'file',
            ],
            'title' => [
                'type' => 'textarea',
                'title' => 'Description',
                'rows' => 2,
                'large' => true,
            ],
            'destinations' => [
                'type' => 'destinations',
            ],
            'submit' => [
                'type' => 'submit',
                'title' => 'Add',
            ],
        ],

        'validate' => [

            'title' => 'required',
            'file' => 'sometimes|required|image',

        ],

    ],

    'add' => [

        'validate' => [

            'title' => 'required',
            'file' => 'required|image',

        ],

    ],

];
