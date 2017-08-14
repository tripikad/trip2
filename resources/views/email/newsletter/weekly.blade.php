@component('mail::newsletter', [
    'unsubscribe_id' => $unsubscribe_id,
])

<table width="100%" cellpadding="5" cellspacing="3">
    <tr>
        <td colspan="2">
            <h1>Möödunud nädal Trip.ee-s</h1>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            @component('mail::promotion.button', [
                'url' => '#',
            ])
            Credit24 annab ära 25 000€ reisiraha! Uuri lähemalt!
            @endcomponent

            <h2>Viimased lennupakkumised:</h2>

            @component('mail::flight', [
                'image' => 'https://trip.ee/images/large/Screen-Shot-2017-08-14-at-17.30.11_ktct.png',
                'url' => '#test',
                'button_color' => 'blue',
            ])
            Lennupiletid talvel Tallinnast eksootilistele Andamani saartele alates 472€
            @endcomponent

            @component('mail::flight', [
                'image' => 'https://trip.ee/images/large/zakynthos_1xzs.jpeg',
                'url' => '#test',
                'button_color' => 'red',
            ])
            Viimase hetke pakkumised Helsingist Kreeka saartele alates 95€
            @endcomponent

            @component('mail::flight', [
                'image' => 'https://trip.ee/images/large/Air_India_k1xx.jpeg',
                'url' => '#test',
                'button_color' => 'green',
            ])
            Air India siselennud üks suund al. 1€, edasi-tagasi al. 9€
            @endcomponent

            <img src="http://www.demareadmare.lv/images/airlines/airbaltic.jpg" class="offset-bottom">

            <h2>Populaarsemad foorumi teemad</h2>

            @component('mail::list', [
                'user' => 'Angela',
                'date' => 'Täna 18:48',
                'destinations' => [
                    [
                        'name' => 'Horvaatia',
                        'url' => '#',
                    ],
                ]
            ])
            Ostud Põhja-Horvaatias
            @endcomponent

            @component('mail::list', [
                'user' => 'LiKu',
                'date' => 'Täna 16:37',
                'destinations' => [
                    [
                        'name' => 'Iisrael',
                        'url' => '#',
                    ],
                ],
                'topics' => [
                    [
                        'name' => 'Turvalisus',
                        'url' => '#',
                    ],
                ]
            ])
            Turvalisus Iisraelis
            @endcomponent

            @component('mail::list', [
                'user' => 'LendaEuroopas',
                'date' => 'Täna 15:59',
                'destinations' => [
                    [
                        'name' => 'Montenegro',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Bosnia ja Hertsegoviina',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Tšehhi',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Austria',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Sloveenia',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Horvaatia',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Ungari',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Slovakkia',
                        'url' => '#',
                    ]
                ],
                'topics' => [
                    [
                        'name' => 'Autoreis',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Lihtsalt puhkusereis',
                        'url' => '#',
                    ]
                ]
            ])
            Balkani reis ning nõuanded
            @endcomponent

            <h2>Reisikaaslaste otsingud</h2>

            @component('mail::list', [
                'user' => 'Kri',
            ])
            34-35 nädal. u nädalane puhkusereis Euroopas.
            @endcomponent

            @component('mail::list', [
                'user' => 'Invictus',
                'destinations' => [
                    [
                        'name' => 'Kanada',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Vancouver',
                        'url' => '#',
                    ]
                ],
                'topics' => [
                    [
                        'name' => 'Töö',
                        'url' => '#',
                    ],
                    [
                        'name' => 'Seljakotireis ja hääletamine',
                        'url' => '#',
                    ]
                ],
            ])
            Kaaslane Kanadasse (WH VIISA, minek sügis-talv)
            @endcomponent

            @component('mail::list', [
                'user' => 'Kadi Põltsam',
                'image' => 'https://trip.ee/images/small_square/user-7326392.png',
                'destinations' => [
                    [
                        'name' => 'Kemer',
                        'url' => '#',
                    ],
                ],
            ])
            Türgi, Kemer
            @endcomponent

            <h2>Viimased uudised</h2>

            @component('mail::news', [
                            'image' => 'https://trip.ee/images/small/Air-NZ-Safety-video_kpmt.jpeg',
                            'date' => '11. Aug 08:34',
            ])
            Lennufirmade turvavideod kui omaette kunstiliik
            @endcomponent

            @component('mail::news', [
                'image' => 'https://trip.ee/images/small/Katar_lpqq.jpeg',
                'date' => '10. Aug 04:56',
            ])
            Katar nüüdsest viisavaba
            @endcomponent

            <h2>Viimased lühiuudised</h2>

            @component('mail::news', [
                'image' => 'https://trip.ee/images/small/Tenerife-teresitas-1_ev1s.jpeg',
                'date' => '10. Aug 10:38',
            ])
            Kanaari saartel levib ohtlik vetikas
            @endcomponent

            @component('mail::news', [
                'image' => 'https://trip.ee/images/small/wizzair_rltz.jpeg',
                'date' => '9. Aug 11:57',
            ])
            Wizzair alustab lende Riiast Eilatisse!
            @endcomponent
        </td>
    </tr>
</table>


@endcomponent
