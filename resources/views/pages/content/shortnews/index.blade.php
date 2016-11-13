@extends('layouts.main')

@section('title', trans("content.$type.index.title"))

@section('header')
    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])
@stop

@section('content')
    <div class="r-forum">
        <div class="r-forum__masthead">
            @include('component.masthead', [
                'modifiers' => 'm-alternative',
                'image' => \App\Image::getHeader()
            ])
        </div>

        <div class="r-forum__wrap m-large-offset-bottom">
            <div class="r-forum__content">
                @if (count($contents))
                    @foreach ($contents as $content)
                        @include('component.row', [
                            'modifiers' => 'm-image',
                            'profile' => [
                                'modifiers' => '',
                                'image' => $content->user->imagePreset(),
                                'route' => ($content->user->name != 'Tripi külastaja' ? route('user.show', [$content->user]) : false)
                            ],
                            'title' => $content->title,
                            'route' => route($content->type.'.show', [$content->slug]),
                            'text' => view('component.content.text', ['content' => $content])
                        ])
                    @endforeach

                    @include('component.pagination.default', [
                        'collection' => $contents
                    ])
                @else
                    <div class="m-small-offset-bottom">
                        @include('component.card', [
                            'text' => (isset($destination) || isset($topic) ?
                                trans('content.flight.filter.no.results') :
                                trans('content.shortnews.no.results')),
                            'modifiers' => 'm-red',
                        ])
                    </div>
                @endif
            </div>
            <div class="r-forum__sidebar">
                <div class="r-block m-small">
                    @include('component.title', [
                        'modifiers' => 'm-red',
                        'title' => trans('content.forum.sidebar.title')
                    ])
                </div>
                <div class="r-block m-small">
                    @include('component.content.forum.nav', [
                        'items' => config('menu.news'),
                    ])
                </div>

                @if (Auth::check() && Auth::user()->hasRole('admin'))
                    <div class="r-block m-small">
                        <div class="r-block__inner">
                            @include('component.button', [
                                'route' => route('content.create', ['type' => $type]),
                                'title' => trans("content.$type.create.title")
                            ])
                        </div>
                    </div>
                @endif

                <div class="r-block m-small m-mobile-hide">
                    @include('component.promo', ['promo' => 'sidebar_small'])
                </div>

                <div class="r-block m-small">
                    <div class="r-block__inner">
                        @include('component.filter')
                    </div>
                </div>

                <div class="r-block m-small m-mobile-hide">
                    @include('component.promo', ['promo' => 'sidebar_large'])
                </div>
            </div>
        </div>

        <div class="r-forum__footer-promo">
            <div class="r-forum__footer-promo-wrap">
                @include('component.promo', ['promo' => 'footer'])
            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getFooter()
    ])
@stop
