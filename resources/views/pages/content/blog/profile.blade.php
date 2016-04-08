@extends('layouts.main')

@section('header')

    @include('component.blog.header',[
        'modifiers' => 'm-profile',
        'back' => [
            'title' => 'trip.ee blogid',
            'route' => '/content/blog'
        ],
    ])
@stop

@section('content')

<div class="r-blog m-profile">

    <div class="r-blog__masthead">

        @include('component.blog.masthead', [
            'modifiers' => 'm-profile',
            'image' => \App\Image::getRandom(),
            'user' => [
                'route' => '#',
                'name' => 'Charles Blunt',
                'description' => 'Designer and writer. Partner at GV. Author of SPRINT. Traveling the world.',
                'color' => 'm-green',
                'letter' => 'J',
                'status' => '1',
                'image' => \App\Image::getRandom(),
                'editor' => true
            ]
        ])
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
