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
            'operation' => 'resize',
            'width' => 900,
            'height' => null,
            'path' => $prepath . 'large/'
        ],
        
        'medium' => [
            'operation' => 'resize',
            'width' => 700,
            'height' => null,
            'path' => $prepath . 'medium/'
        ],
        
        'small' => [
            'operation' => 'resize',
            'width' => 300,
            'height' => null,
            'path' => $prepath . 'small/'
        ],
        
        'small_square' => [
            'operation' => 'fit',
            'width' => 180,
            'height' => null,
            'path' => $prepath . 'small_square/'
        ],
        
        'xsmall_square' => [
            'operation' => 'fit',
            'width' => 80,
            'height' => null,
            'path' => $prepath . 'xsmall_square/'
        ]

    ]
];