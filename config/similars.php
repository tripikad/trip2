<?php

return [

    'totalsize' => env('SIMILARS_TOTAL_SIZE', 500),
    'chunksize' => env('SIMILARS_CHUNK_SIZE', 10),

    'destination' => [
        'filter' => [
            'Eesti',
            'Tallinn',
            'Pai',
            'Are',
            'Euroopa',
            'Riia'
        ],
        'parentfilter' => [
            'Euroopa',
            'Aasia'
        ],
        'add' => [    
            'Niagra',
            'Maroco',
            'Qatar',
            'Douro',
            'Las Palmas',
            'Los Gigantes',
            'Krabi',
            'Sharm',
            'Mekong',
            'Busuanga',
            'Panglao',
            'Serengeti',
            'Vantaa',
            'Caymani saared',
            'Fort Lauderdale',
            'Warsaw',
            'Phi Phi',
            'Belek',
            'Nassau',
            'Pokhara',
            'Yukatan',
            'Stansted',
            'Gatwick',
            'Doha'
        ],
    ],

    'topic' => [
        'filter' => [
            'Töö'
        ],
        'add' => [
            'Päike',
            'Alkohol',
            'Voodi',
            'Beebi',
            'Shoppam',
            'Majutus',
            'Hotell',
            'Apartment',
            'Vaktsi',
            'Vaksi',
            'Viisa',
            'Söök',
            'Autoren',
            'Lennujaam',
            'Safari',
            'Lapse',
            'Rannapuhkus',
            'Passi',
            'Lennupilet',
            'Krediitkaart',
            'Pangakaart',
            'Juhilu',
            'Juhilo',
        ]
    ],

    'carrier' => [
        'filter' => [
            'Delta'
        ],
        'add' => [
            'Wizzair',
            'Aeromexico',
            'Ethiopian Airlines',
            'Expedia',
            'Novatours',
            'Albamare',
            'Airbnb',
            'Eckerö Line',
        ]
    ]
];