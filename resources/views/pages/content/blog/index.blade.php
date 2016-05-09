@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('header')

    @include('component.blog.header',[
        'modifiers' => 'm-alternative',
        'back' => [
            'title' => 'trip.ee',
            'route' => '/'
        ],
        'logo' => true
    ])
@stop

@section('content')


    <!--
    @foreach ($contents as $content)

        @include('component.row', [
            'modifiers' => 'm-image',
            'profile' => [
                'modifiers' => '',
                'image' => $content->user->imagePreset(),
                'route' => route('user.show', [$content->user])
            ],
            'title' => $content->title,
            'route' => route('content.show', [$content->type, $content->id]),
            'text' => view('component.content.text', ['content' => $content]),
            'body' => $content->body_filtered,
        ])

    @endforeach

    @include('component.pagination.default', [
        'collection' => $contents
    ])
    -->

<div class="r-blog m-index">

    <div class="r-blog__masthead">

        @include('component.blog.masthead', [
            'modifiers' => 'm-index'
        ])
    </div>

    <div class="r-blog__featured-main">

        <div class="r-blog__wrap">

            <div class="c-blog-featured m-video">

                <a href="/content/blog/91258" class="c-blog-featured__image-link" style="background-image: url({{\App\Image::getRandom()}});">
                    <span class="c-blog-featured__type">
                        @include('component.svg.sprite', [
                            'name' => 'icon-video'
                        ])
                    </span>
                </a>

                <div class="c-blog-featured__content">

                    <h3 class="c-blog-featured__title"><a href="/content/blog/91258" class="c-blog-featured__title-link">Motikaga Gruusias, Armeenias ja Karabahhis</a></h3>
                    <p class="c-blog-featured__excerpt">Tbilisi suur probleem on jalakäijatele mitte mõtlemine -- raske on liikuda kesklinnas ja ületada mitmerealisi tänavaid, mis on paksult autosid täis. On mõningad tunnelid jalakäijatele kuid natuke linnasüdamest eemal on need pimedad ja kohati ka…</p>

                    <div class="c-blog-featured__tags">

                        @include('component.blog.tags', [
                            'items' => [
                                [
                                    'title' => 'Gruusia',
                                    'route' => '#'
                                ],
                                [
                                    'title' => 'Armeenia',
                                    'route' => '#'
                                ],
                                [
                                    'title' => 'Aserbaidžaan',
                                    'route' => '#'
                                ],
                                [
                                    'title' => 'Video',
                                    'route' => '#'
                                ]
                            ]
                        ])
                    </div>

                    <div class="c-blog-featured__meta">

                        <div class="c-blog-featured__user">

                            <div class="c-blog-featured__user-image">

                                @include('component.profile', [
                                    'modifiers' => 'm-full m-status',
                                    'image' => \App\Image::getRandom(),
                                    'route' => '#',
                                    'letter' => [
                                        'modifiers' => 'm-yellow m-small',
                                        'text' => 'J'
                                    ],
                                    'status' => [
                                        'modifiers' => 'm-yellow',
                                        'position' => '3',
                                    ]
                                ])
                            </div>
                            <a href="#" class="c-blog-featured__user-name">Charles Blunt</a>
                        </div>

                        <p class="c-blog-featured__date">10. jaanuar</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="r-blog__featured-list">

        <div class="r-blog__wrap">

            <div class="c-columns m-4-cols m-space">

                <div class="c-columns__item">

                    <div class="c-blog-featured m-small m-video">

                        <a href="#" class="c-blog-featured__image-link" style="background-image: url({{\App\Image::getRandom()}});">
                            <span class="c-blog-featured__type">
                                @include('component.svg.sprite', [
                                    'name' => 'icon-video'
                                ])
                            </span>
                        </a>

                        <div class="c-blog-featured__content">

                            <h3 class="c-blog-featured__title"><a href="#" class="c-blog-featured__title-link">Mõneks kuuks kodus – Cotonou, Lagos ja Calabar</a></h3>

                            <div class="c-blog-featured__tags">

                                @include('component.blog.tags', [
                                    'items' => [
                                        [
                                            'title' => 'Aafrika',
                                            'route' => '#'
                                        ],
                                        [
                                            'title' => 'Seljakotireis',
                                            'route' => '#'
                                        ]
                                    ]
                                ])
                            </div>

                            <div class="c-blog-featured__meta">

                                <div class="c-blog-featured__user">

                                    <div class="c-blog-featured__user-image">

                                        @include('component.profile', [
                                            'modifiers' => 'm-full m-status',
                                            'image' => \App\Image::getRandom(),
                                            'route' => '#',
                                            'letter' => [
                                                'modifiers' => 'm-green m-small',
                                                'text' => 'J'
                                            ],
                                            'status' => [
                                                'modifiers' => 'm-green',
                                                'position' => '2',
                                            ]
                                        ])
                                    </div>
                                    <a href="#" class="c-blog-featured__user-name">Arne Uusjärv</a>
                                </div>

                                <p class="c-blog-featured__date">01. jaanuar</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-columns__item">

                    <div class="c-blog-featured m-small">

                        <a href="#" class="c-blog-featured__image-link" style="background-image: url({{\App\Image::getRandom()}});"></a>

                        <div class="c-blog-featured__content">

                            <h3 class="c-blog-featured__title"><a href="#" class="c-blog-featured__title-link">Riisipõllud, pho ja muud jutud mägises Sapa’s, Vietnamis</a></h3>
                            <p class="c-blog-featured__excerpt">Magasingi ühes bäkkerihostelis pärastlõunani ja läksin seejärel linna peale süüa otsima. Kui tagasi jõudsin, oli hostelis parasjagu alanud happy hour…</p>

                            <div class="c-blog-featured__tags">

                                @include('component.blog.tags', [
                                    'items' => [
                                        [
                                            'title' => 'Vietnam',
                                            'route' => '#'
                                        ]
                                    ]
                                ])
                            </div>

                            <div class="c-blog-featured__meta">

                                <div class="c-blog-featured__user">

                                    <div class="c-blog-featured__user-image">

                                        @include('component.profile', [
                                            'modifiers' => 'm-full m-status',
                                            'image' => '',
                                            'route' => '#',
                                            'letter' => [
                                                'modifiers' => 'm-yellow m-small',
                                                'text' => 'K'
                                            ],
                                            'status' => [
                                                'modifiers' => 'm-yellow',
                                                'position' => '2',
                                            ]
                                        ])
                                    </div>
                                    <a href="#" class="c-blog-featured__user-name">Kiir Krooks</a>
                                </div>

                                <p class="c-blog-featured__date">24. veebruar</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-columns__item">

                    <div class="c-blog-featured m-small">

                        <a href="#" class="c-blog-featured__image-link" style="background-image: url({{\App\Image::getRandom()}});"></a>

                        <div class="c-blog-featured__content">

                            <h3 class="c-blog-featured__title"><a href="#" class="c-blog-featured__title-link">Mõneks kuuks kodus – Cotonou, Lagos ja Calabar</a></h3>
                            <p class="c-blog-featured__excerpt">Cotonoust Lagosesse sõitsin taksoga ja kuna Benini Vabariigi suurim linn Cotonou asub üsna Nigeeria piiri lähedal (32 km), siis jõudsin…</p>

                            <div class="c-blog-featured__tags">

                                @include('component.blog.tags', [
                                    'items' => [
                                        [
                                            'title' => 'Aafrika',
                                            'route' => '#'
                                        ],
                                        [
                                            'title' => 'Seljakotireis',
                                            'route' => '#'
                                        ]
                                    ]
                                ])
                            </div>

                            <div class="c-blog-featured__meta">

                                <div class="c-blog-featured__user">

                                    <div class="c-blog-featured__user-image">

                                        @include('component.profile', [
                                            'modifiers' => 'm-full m-status',
                                            'image' => \App\Image::getRandom(),
                                            'route' => '#',
                                            'letter' => [
                                                'modifiers' => 'm-red m-small',
                                                'text' => 'J'
                                            ],
                                            'status' => [
                                                'modifiers' => 'm-red',
                                                'position' => '3',
                                            ]
                                        ])
                                    </div>
                                    <a href="#" class="c-blog-featured__user-name">Arne Uusjärv</a>
                                </div>

                                <p class="c-blog-featured__date">01. jaanuar</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="c-columns__item">

                    <div class="c-blog-featured m-small">

                        <a href="#" class="c-blog-featured__image-link" style="background-image: url({{\App\Image::getRandom()}});"></a>

                        <div class="c-blog-featured__content">

                            <h3 class="c-blog-featured__title"><a href="#" class="c-blog-featured__title-link">Riisipõllud, pho ja muud jutud mägises Sapa’s, Vietnamis</a></h3>
                            <p class="c-blog-featured__excerpt">Magasingi ühes bäkkerihostelis pärastlõunani ja läksin seejärel linna peale süüa otsima. Kui tagasi jõudsin, oli hostelis parasjagu alanud happy hour…</p>

                            <div class="c-blog-featured__tags">

                                @include('component.blog.tags', [
                                    'items' => [
                                        [
                                            'title' => 'Vietnam',
                                            'route' => '#'
                                        ]
                                    ]
                                ])
                            </div>

                            <div class="c-blog-featured__meta">

                                <div class="c-blog-featured__user">

                                    <div class="c-blog-featured__user-image">

                                        @include('component.profile', [
                                            'modifiers' => 'm-full m-status',
                                            'image' => \App\Image::getRandom(),
                                            'route' => '#',
                                            'letter' => [
                                                'modifiers' => 'm-blue m-small',
                                                'text' => 'J'
                                            ],
                                            'status' => [
                                                'modifiers' => 'm-blue',
                                                'position' => '1',
                                            ]
                                        ])
                                    </div>
                                    <a href="#" class="c-blog-featured__user-name">Kiir Krooks</a>
                                </div>

                                <p class="c-blog-featured__date">24. veebruar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="r-blog__featured-sponsored">

        <div class="r-blog__wrap">

            <div class="c-columns m-3-cols m-space">

                <div class="c-columns__item">

                    @include('component.blog.sponsored', [
                        'title' => 'Meie loodenaaber Rootsi ja tema käimata rajad.',
                        'route' => '#',
                        'image' => \App\Image::getRandom(),
                    ])
                </div>

                <div class="c-columns__item">

                    @include('component.blog.sponsored', [
                        'title' => 'Põhja-Soome metsamajakesed, jahiturism ja kalastuskohad.',
                        'route' => '#',
                        'image' => \App\Image::getRandom(),
                    ])
                </div>

                <div class="c-columns__item">

                    @include('component.blog.sponsored', [
                        'title' => 'Rännumehe reisisoovitused vol 18 - kuhu ning kuidas Eestis rändama minna',
                        'route' => '#',
                        'image' => \App\Image::getRandom(),
                    ])
                </div>
            </div>
        </div>
    </div>

    <div class="r-blog__main">

        <div class="r-blog__wrap">

            <div class="r-blog__main-content">

                <div class="r-block m-small m-no-mobile-margin">

                    <div class="r-block__header">
                        @include('component.title', [
                            'modifiers' => 'm-gray',
                            'title' => 'Värsked postitused'
                        ])
                    </div>

                    <div class="c-blog-article">

                        <h3 class="c-blog-article__title"><a href="#" class="c-blog-article__title-link">Rännumehe reisisoovitused vol 18 – kuhu ning kuidas Eestis rändama minna</a></h3>

                        <a href="#" class="c-blog-article__image-link" style="background-image: url({{\App\Image::getRandom()}});"></a>

                        <div class="c-blog-article__content">

                            <p class="c-blog-article__excerpt">Paljude jaoks on suvi läbi saamas ning algamas uus töö- või kooliaasta. Suvelõpu lõõgastava elamuse saamiseks soovitab rännumees Marko Kaldur ette võtta paadireisi mõnele Eesti…</p>

                            <div class="c-blog-article__tags">

                                @include('component.blog.tags', [
                                    'items' => [
                                        [
                                            'title' => 'Mis-mu-seljakotis-on',
                                            'route' => '#'
                                        ],
                                        [
                                            'title' => 'Video',
                                            'route' => '#'
                                        ]
                                    ]
                                ])
                            </div>

                            <div class="c-blog-article__meta">

                                <div class="c-blog-article__user">

                                    <div class="c-blog-article__user-image">

                                        @include('component.profile', [
                                            'modifiers' => 'm-full m-status',
                                            'image' => \App\Image::getRandom(),
                                            'route' => '#',
                                            'letter' => [
                                                'modifiers' => 'm-yellow m-small',
                                                'text' => 'J'
                                            ],
                                            'status' => [
                                                'modifiers' => 'm-yellow',
                                                'position' => '2',
                                            ]
                                        ])
                                    </div>
                                    <a href="#" class="c-blog-article__user-name">Madis Mesikäpp</a>
                                </div>

                                <p class="c-blog-article__date">02. märts</p>
                            </div>
                        </div>
                    </div>

                    <div class="c-blog-article__divider"></div>

                    <div class="c-blog-article m-video">

                        <h3 class="c-blog-article__title"><a href="#" class="c-blog-article__title-link">Beginner’s Guide to Travel Hacking: Travel Anywhere, Pay (Almost) Nothing</a></h3>

                        <a href="#" class="c-blog-article__image-link" style="background-image: url({{\App\Image::getRandom()}});">
                            <span class="c-blog-article__type">
                                @include('component.svg.sprite', [
                                    'name' => 'icon-video'
                                ])
                            </span>
                        </a>

                        <div class="c-blog-article__content">

                            <div class="c-blog-article__tags">

                                @include('component.blog.tags', [
                                    'items' => [
                                        [
                                            'title' => 'Video',
                                            'route' => '#'
                                        ],
                                        [
                                            'title' => 'Mis-mu-seljakotis-on',
                                            'route' => '#'
                                        ]
                                    ]
                                ])
                            </div>

                            <div class="c-blog-article__meta">

                                <div class="c-blog-article__user">

                                    <div class="c-blog-article__user-image">

                                        @include('component.profile', [
                                            'modifiers' => 'm-full m-status',
                                            'image' => \App\Image::getRandom(),
                                            'route' => '#',
                                            'letter' => [
                                                'modifiers' => 'm-yellow m-small',
                                                'text' => 'J'
                                            ],
                                            'status' => [
                                                'modifiers' => 'm-yellow',
                                                'position' => '2',
                                            ]
                                        ])
                                    </div>
                                    <a href="#" class="c-blog-article__user-name">Tiiu Roosioja</a>
                                </div>

                                <p class="c-blog-article__date">01. märts</p>
                            </div>
                        </div>
                    </div>

                    <div class="c-blog-article__divider"></div>

                    <div class="c-blog-article">

                        <h3 class="c-blog-article__title"><a href="#" class="c-blog-article__title-link">How to Manage a Continent</a></h3>

                        <a href="#" class="c-blog-article__image-link" style="background-image: url({{\App\Image::getRandom()}});"></a>

                        <div class="c-blog-article__content">

                            <p class="c-blog-article__excerpt">In the two years since graduating from college, I’ve been taking free round trip flights around the world using a strategy called “churning”. A few destinations I’ve visited or will visit soon: Florence…</p>

                            <div class="c-blog-article__meta">

                                <div class="c-blog-article__user">

                                    <div class="c-blog-article__user-image">

                                        @include('component.profile', [
                                            'modifiers' => 'm-full m-status',
                                            'image' => \App\Image::getRandom(),
                                            'route' => '#',
                                            'letter' => [
                                                'modifiers' => 'm-yellow m-small',
                                                'text' => 'J'
                                            ],
                                            'status' => [
                                                'modifiers' => 'm-yellow',
                                                'position' => '2',
                                            ]
                                        ])
                                    </div>
                                    <a href="#" class="c-blog-article__user-name">Arnari Kerning</a>
                                </div>

                                <p class="c-blog-article__date">10. jaanuar</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="r-block m-mobile-hide">

                    @include('component.promo', ['promo' => 'body'])

                </div>

                <div class="r-block m-small">

                    <div class="c-blog-article m-last">

                        <h3 class="c-blog-article__title"><a href="#" class="c-blog-article__title-link">Zhangbei, China, is a county formerly in the Chahar province</a></h3>

                        <a href="#" class="c-blog-article__image-link" style="background-image: url({{\App\Image::getRandom()}});"></a>

                        <div class="c-blog-article__content">

                            <p class="c-blog-article__excerpt">In the two years since graduating from college, I’ve been taking free round trip flights around the world using a strategy called “churning”. A few destinations I’ve visited or will visit soon: Florence…</p>

                            <div class="c-blog-article__meta">

                                <div class="c-blog-article__user">

                                    <div class="c-blog-article__user-image">

                                        @include('component.profile', [
                                            'modifiers' => 'm-full m-status',
                                            'image' => \App\Image::getRandom(),
                                            'route' => '#',
                                            'letter' => [
                                                'modifiers' => 'm-yellow m-small',
                                                'text' => 'J'
                                            ],
                                            'status' => [
                                                'modifiers' => 'm-yellow',
                                                'position' => '2',
                                            ]
                                        ])
                                    </div>
                                    <a href="#" class="c-blog-article__user-name">Arnari Kerning</a>
                                </div>

                                <p class="c-blog-article__date">10. jaanuar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="r-blog__main-sidebar">

                <div class="r-block m-small">

                    <div class="r-block__header">
                        @include('component.title', [
                            'modifiers' => 'm-gray',
                            'title' => 'Populaarsed teemad'
                        ])
                    </div>

                    @include('component.blog.tags', [
                        'items' => [
                            [
                                'title' => 'Aafrika',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Põhja-Ameerika',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Reisipäevik',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Jaapan',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Hiina',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Seljakotireis',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Mis-mu-seljakotis-on',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Tai',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Reisiideed',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Eesti',
                                'route' => '#'
                            ],
                            [
                                'title' => 'Tokyo',
                                'route' => '#'
                            ]
                        ]
                    ])
                </div>

                <div class="r-block m-small">

                    <div class="r-block__header">
                        @include('component.title', [
                            'modifiers' => 'm-gray',
                            'title' => 'Trip.ee blogist'
                        ])
                    </div>

                    <div class="c-body">
                        <p>Trip.ee reisiblogi on koht kus jagada oma ideid, kogemusi ja näpunäiteid. Kõik me oleme unikaalsed, kõigil meist on mõni lugu rääkida – ja kellele ei meeldiks lugeda üht.</p>
                    </div>
                </div>

                <div class="r-block m-small">

                    <div class="r-block__header">
                        @include('component.title', [
                            'modifiers' => 'm-gray',
                            'title' => 'Valitud autorid'
                        ])
                    </div>

                    @include('component.blog.authors', [
                        'items' => [
                            [
                                'title' => 'Kaupo Kõrval',
                                'route' => '#',
                                'image' => \App\Image::getRandom()
                            ],
                            [
                                'title' => 'Märt-Villem Villemsaar',
                                'route' => '#',
                                'image' => \App\Image::getRandom()
                            ],
                            [
                                'title' => 'Allar Levandi',
                                'route' => '#',
                                'image' => \App\Image::getRandom()
                            ],
                            [
                                'title' => 'Johann jr Järviste',
                                'route' => '#',
                                'image' => \App\Image::getRandom()
                            ],
                            [
                                'title' => 'Helena Parma',
                                'route' => '#',
                                'image' => \App\Image::getRandom()
                            ],
                            [
                                'title' => 'Lauri-Robert Tähr',
                                'route' => '#',
                                'image' => \App\Image::getRandom()
                            ],
                        ]
                    ])
                </div>

                <div class="r-block m-small m-mobile-hide">

                    @include('component.promo', ['promo' => 'sidebar_small'])

                </div>

                <div class="r-block m-small m-mobile-hide">

                    @include('component.promo', ['promo' => 'sidebar_large'])

                </div>
            </div>
        </div>
    </div>

    <div class="r-blog__offers">

        <div class="r-blog__wrap">

            <div class="c-columns m-3-cols">

                <div class="c-columns__item">

                    @include('component.card', [
                        'route' => '#',
                        'title' => 'Edasi-tagasi Riiast või Helsingist Bangkoki al. 350 €',
                        'image' => \App\Image::getRandom()
                    ])
                </div>

                <div class="c-columns__item">

                    @include('component.card', [
                        'route' => '#',
                        'title' => 'Air China Stockholmist Filipiinidele, Singapuri või Hongkongi al. 285 €',
                        'image' => \App\Image::getRandom()
                    ])
                </div>

                <div class="c-columns__item">

                    @include('component.card', [
                        'route' => '#',
                        'title' => 'Riiast Maltale al. 350 €',
                        'image' => \App\Image::getRandom()
                    ])
                </div>
            </div>
        </div>
    </div>

    <div class="r-blog__footer-promo">

        <div class="r-blog__wrap">

           @include('component.promo', ['promo' => 'footer'])

        </div>
    </div>
</div>

@stop

@section('footer')

    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getRandom()
    ])

@stop
