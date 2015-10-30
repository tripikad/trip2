@extends('layouts.main')

@section('title')

    {{ $content->title }}

@stop

@section('header1.image')

    @if($content->images())

        {{ $content->imagePreset('large') }}

    @endif

@stop

@section('content')

<div class="r-flights m-single">

<<<<<<< HEAD
    <div class="r-flights__masthead">

        @include('component.masthead')
=======
    @include('component.row', [
        'profile' => [
            'modifiers' => '',
            'image' => $content->user->imagePreset(),
            'route' => route('user.show', [$content->user])
        ],
        'text' => view('component.content.text', ['content' => $content]),
        'actions' => view('component.actions', ['actions' => $content->getActions()]),
        'extra' => view('component.flags', ['flags' => $content->getFlags()]),
        'body' => $content->body_filtered,
        'modifiers' => '-centered'
    ])
>>>>>>> master

    </div>

    <div class="r-flights__content-wrap">

        <div class="r-flights__content">

            <div class="c-body">

                @include('component.row', [
                    'image' => $content->user->imagePreset(),
                    'image_link' => route('user.show', [$content->user]),
                    'description' => view('component.content.description', ['content' => $content]),
                    'actions' => view('component.actions', ['actions' => $content->getActions()]),
                    'extra' => view('component.flags', ['flags' => $content->getFlags()]),
                    'body' => $content->body_filtered,
                    'options' => '-centered'
                ])

            </div>


            @include('component.comment.index', ['comments' => $comments])

            @if (\Auth::check())

                @include('component.comment.create')

            @endif

        </div>

        <div class="r-flights__sidebar">

            <div class="r-flights__about">

                @include('component.about', [
                    'title' => 'Hoiame headel pakkumistel igapäevaselt silma peal ning jagame neid kõigi huvilistega.',
                    'text' => 'Pakkumised võivad aeguda juba paari päevaga. Paremaks orienteerumiseks on vanemad pakkumised eri värvi.',
                    'links' => [
                        [
                            'title' => 'Loe lähemalt Trip.ee-st ›',
                            'route' => '#'
                        ],
                        [
                            'title' => 'Mis on veahind ›',
                            'route' => '#',
                        ]
                    ]
                ])

            </div>

            <div class="r-flights__promo">

                @include('component.promo', [
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])

            </div>

            <div class="r-flights__promo">

                @include('component.promo', [
                    'route' => '',
                    'image' => \App\Image::getRandom()
                ])

            </div>

            <div class="r-flights__about">

                @include('component.about', [
                    'title' => 'Trip.ee on reisihuviliste kogukond, keda ühendab reisipisik ning huvi kaugete maade ja kultuuride vastu.',
                    'links' => [
                        [
                            'title' => 'Loe lähemalt Trip.ee-st ›',
                            'route' => '#'
                        ],
                        [
                            'title' => 'Trip.ee Facebookis ›',
                            'route' => '#',
                        ],
                        [
                            'title' => 'Trip.ee Twitteris ›',
                            'route' => '#',
                        ]
                    ],
                    'button' => [
                        'title' => 'Liitu Trip.ee-ga',
                        'route' => '#',
                        'modifiers' => 'm-block'
                    ]
                ])

            </div>

        </div>

    </div>

</div>

<div class="r-flights__footer-promo">

    <div class="r-flights__footer-promo-wrap">

        @include('component.promo', [
            'route' => '#',
            'image' => \App\Image::getRandom()
        ])

    </div>
</div>

@stop
