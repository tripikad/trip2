@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('content')

<div class="r-forum m-single">

    <div class="r-forum__masthead">

        @include('component.masthead')
    </div>

    <div class="r-forum__wrap">

        <div class="r-forum__content">

            @include('component.row', [
                'profile' => [
                    'modifiers' => 'm-small',
                    'image' => $content->user->imagePreset(),
                    'route' => route('user.show', [$content->user])
                ],
                'modifiers' => 'm-image' . (count($comments) ? ' m-featured' : ''),
                'title' => $content->title,
                'text' => view('component.content.text', ['content' => $content]),
                'actions' => view('component.actions', ['actions' => $content->getActions()]),
                'extra' => view('component.flags', ['flags' => $content->getFlags()]),
                'body' => $content->body_filtered,
            ])

            @include('component.comment.index', ['comments' => $comments])

            @if (\Auth::check())

                @include('component.comment.create')

            @endif

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

        </div>

    </div>

</div>

@stop
