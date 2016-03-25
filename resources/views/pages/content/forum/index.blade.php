@extends('layouts.main')

@section('header')

    @include('component.header', [
        'hide' => ['search'],
    ])

@stop

@section('masthead.search')

    @include('component.search',[
        'modifiers' => 'm-red m-inverted',
        'placeholder' => 'Otsi foorumist...',
    ])

@stop

@section('title')
    foorum
@stop

@section('content')
    <div class="r-forum">

        <div class="r-forum__masthead">

            @include('component.masthead', [
                'modifiers' => 'm-search m-logo-title',
                'map' => true,
            ])

        </div>

        <div class="r-forum__wrap">

            <div class="r-forum__content">

                @foreach ($contents as $content)

                    @include('component.row', [
                        'profile' => [
                            'modifiers' => '',
                            'image' => $content->user->imagePreset(),
                            'route' => route('user.show', [$content->user]),
                            'letter' => [
                                'modifiers' => 'm-green m-small',
                                'text' => 'D'
                            ],
                        ],
                        'modifiers' => 'm-image',
                        'title' => $content->title,
                        'route' => route('content.show', [$content->type, $content->id]),
                        'text' => view('component.content.text', ['content' => $content]),
                    ])

                @endforeach

                @include('component.pagination.default', [
                    'collection' => $contents
                ])

            </div>

            <div class="r-forum__sidebar">

                <div class="r-forum__sidebar-block">

                    <div class="r-forum__sidebar-block-inner">

                        @include('component.nav', [
                            'modifiers' => '',
                            'menu' => config('content_'.$type.'.menu'),
                            'items' => config('menu.'.config('content_'.$type.'.menu'))
                        ])

                    </div>

                </div>

                @if (\Auth::check())

                    <div class="r-forum__sidebar-block">

                        <div class="r-forum__sidebar-block-inner">

                            @include('component.button', [
                                'route' => route('content.create', ['type' => $type]),
                                'title' => trans("content.$type.create.title")
                            ])

                        </div>

                    </div>

                @endif

                <div class="r-forum__sidebar-block">

                    <div class="r-forum__sidebar-block-inner">

                        @include('component.filter')

                    </div>

                </div>

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
