@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

<div class="r-travelmates">

    <div class="r-travelmates__masthead">

        @include('component.masthead', [
            'modifiers' => 'm-alternative',
            'image' => \App\Image::getRandom()
        ])
    </div>

    <div class="r-travelmates__wrap">

        <div class="r-travelmates__content">

            @if (count($contents))

                @include('component.travelmate.list', [
                    'modifiers' => 'm-2col',
                    'items' => $contents->take(8)->transform(function ($content) {
                        return [
                            'modifiers' => '',
                            'image' =>  $content->user->imagePreset('small_square'),
                            'name' => $content->user->name,
                            'route' => route('content.show', [$content->type, $content]),
                            'sex_and_age' => 'N,28',
                            'title' => $content->title,
                            'tags' => [
                                [
                                    'modifiers' => 'm-yellow',
                                    'title' => 'India'
                                ],
                                [
                                    'modifiers' => 'm-purple',
                                    'title' => 'Delhi'
                                ]
                            ]
                        ];
                    })
                ])

            @endif

            <div class="r-block m-small">

                @include('component.promo', [
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])

            </div>

            @if (count($contents))

                @include('component.travelmate.list', [
                    'modifiers' => 'm-2col',
                    'items' => $contents->splice(8)->take(8)->transform(function ($content) {
                        return [
                            'modifiers' => '',
                            'image' => $content->user->imagePreset('small_square'),
                            'name' => $content->user->name,
                            'route' => route('content.show', [$content->type, $content]),
                            'sex_and_age' => 'N,28',
                            'title' => $content->title,
                            'tags' => [
                                [
                                    'modifiers' => 'm-yellow',
                                    'title' => 'India'
                                ],
                                [
                                    'modifiers' => 'm-purple',
                                    'title' => 'Delhi'
                                ]
                            ]
                        ];
                    })
                ])

            @endif

            @include('component.pagination',
                ['collection' => $contents]
            )

        </div>

        <div class="r-travelmates__sidebar">

            <div class="r-block m-small">

                <div class="r-block__inner">

                    @include('component.about', [
                        'title' => 'Soovid kaaslaseks eksperti oma esimesele matkareisile? Lihtsalt seltsilist palmi alla?',
                        'text' => 'Siit leiad omale sobiva reisikaaslase. Kasuta ka allpool olevat filtrit soovitud tulemuste saamiseks.',
                        'links' => [
                            [
                                'modifiers' => 'm-icon',
                                'title' => 'Reeglid',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'modifiers' => 'm-icon',
                                'title' => 'Kellele ja miks?',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ]
                        ],
                        'button' => [
                            'modifiers' => 'm-block',
                            'route' => route('content.create', ['type' => $type]),
                            'title' => trans("content.$type.create.title")
                        ]
                    ])

                </div>
            </div>

            <div class="r-block m-small">

                {{-- @include('component.filter') --}}

                <div class="r-block__inner">

                    <div class="r-block__header">

                        <div class="r-block__header-title">

                            @include('component.title', [
                                'title' => 'Filter',
                                'modifiers' => 'm-large m-green'
                            ])

                        </div>

                        <div class="c-body">
                            <p>Kui ei leia sobivat kaaslast, siis ehk aitab sind filter.</p>
                        </div>
                    </div>

                    <div class="r-block__body">

                        <div class="c-form__group m-small-margin">
                            <select name="" id="" class="c-form__input">
                                <option value="">Riik</option>
                            </select>
                        </div>

                        <div class="c-form__group m-small-margin">
                            <select name="" id="" class="c-form__input">
                                <option value="">Linn</option>
                            </select>
                        </div>

                        <div class="c-form__group m-small-margin">
                            <select name="" id="" class="c-form__input">
                                <option value="">Reisistiil</option>
                            </select>
                        </div>

                        <div class="c-form__group m-small-margin">
                            <select name="" id="" class="c-form__input">
                                <option value="">Vanus</option>
                            </select>
                        </div>

                        <div class="c-form__group m-small-margin">
                            <select name="" id="" class="c-form__input">
                                <option value="">Sugu</option>
                                <option value="">Mees</option>
                                <option value="">Naine</option>
                            </select>
                        </div>

                        @include('component.button', [
                            'modifiers' => 'm-block',
                            'title' => 'Filtreeri',
                            'route' => ''
                        ])

                    </div>
                </div>
            </div>

            <div class="r-block m-small">

                @include('component.promo', [
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])
            </div>

            <div class="r-block m-small">

                <div class="r-block__inner">

                    @include('component.about', [
                        'title' => 'Trip.ee on reisihuviliste kogukond, keda ühendab reisipisik ning huvi kaugete maade ja kultuuride vastu.',
                        'links' => [
                            [
                                'modifiers' => 'm-icon',
                                'title' => 'Loe lähemalt Trip.ee-st',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'modifiers' => 'm-icon',
                                'title' => 'Trip.ee Facebookis',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ],
                            [
                                'modifiers' => 'm-icon',
                                'title' => 'Trip.ee Twitteris',
                                'route' => '#',
                                'icon' => 'icon-arrow-right'
                            ]
                        ],
                        'button' => [
                            'modifiers' => 'm-block',
                            'route' => '',
                            'title' => 'Liitu Trip.ee-ga'
                        ]
                    ])

                </div>
            </div>
        </div>
    </div>

    <div class="r-travelmates__footer-promo">

        <div class="r-travelmates__footer-promo-wrap">

            @include('component.promo', [
                'route' => '',
                'image' => \App\Image::getRandom()
            ])
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