<?php

$prepath = public_path() . '/images/';

return [

    'original' => [
        'width' => null,
        'height' => null,
        'path' => $prepath . 'original/'
    ],

    'presets' => [

        'large' => [
            'width' => 900,
            'height' => null,
            'path' => $prepath . 'large/'
        ],
        
        'medium' => [
            'width' => 700,
            'height' => null,
            'path' => $prepath . 'medium/'
        ],
        
        'small' => [
            'width' => 300,
            'height' => null,
            'path' => $prepath . 'small/'
        ],
        
        'small_square' => [
            'width' => 180,
            'height' => null,
            'path' => $prepath . 'small_square/'
        ],
        
        'xsmall_square' => [
            'width' => 80,
            'height' => null,
            'path' => $prepath . 'xsmall_square/'
        ]

    ]
];