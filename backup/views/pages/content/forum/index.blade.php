@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('content')

    <div class="r-forum">

        <div class="r-forum__masthead">

            @include('component.masthead')
        </div>

        <div class="r-forum__wrap">

            <div class="r-forum__content">

                @foreach ($contents as $content)

                    @include('component.row', [
                        'profile' => [
                            'modifiers' => '',
                            'image' => $content->user->imagePreset(),
                            'route' => route('user.show', [$content->user])
                        ],
                        'modifiers' => 'm-image',
                        'title' => $content->title,
                        'route' => route('content.show', [$content->type, $content->id]),
                        'text' => view('component.content.text', ['content' => $content]),
                    ])

                @endforeach

                @include('component.pagination',
                    ['collection' => $contents]
                )
            </div>

            <div class="r-forum__sidebar">

                <div class="r-forum__sidebar-block">

                    <div class="r-forum__sidebar-block-inner">

                        @include('component.nav', [
                            'modifiers' => '',
                            'menu' => 'forum',
                            'items' => config('menu.forum')
                        ])

                    </div>

                </div>

                <div class="r-forum__sidebar-block">

                    <div class="r-forum__sidebar-block-inner">

                        @include('component.button', [
                            'route' => route('content.create', ['type' => $type]),
                            'title' => trans("content.$type.create.title")
                        ])

                    </div>

                </div>

                <div class="r-forum__sidebar-block">

                    <div class="r-forum__sidebar-block-inner">

                        @include('component.filter')

                    </div>

                </div>

            </div>

        </div>

    </div>

@stop
