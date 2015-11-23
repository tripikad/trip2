@extends('layouts.one_column')

@section('title')

    {{ trans('follow.index.title', ['user' => $user->name]) }}

@stop

@section('header2.content')

    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))

        @include('component.nav', [
            'menu' => 'user',
            'items' => [
                'activity' => ['route' => route('user.show', [$user])],
                'message' => ['route' => route('message.index', [$user])],
                'follow' => ['route' => route('follow.index', [$user])]
            ],
            'modifiers' => ''
        ])

    @endif

@stop

@section('content.one')

    @if (count($user->follows))

        @foreach ($user->follows as $follow)

                @include('component.row', [
                    'modifiers' => 'm-image',
                    'profile' => [
                        'modifiers' => '',
                        'image' => $follow->followable->user->imagePreset(),
                        'route' => route('user.show', [$follow->followable->user])
                    ],
                    'title' => $follow->followable->title,
                    'route' => route('content.show', [
                        $follow->followable->type,
                        $follow->followable
                    ]),
                    'text' => view('component.content.text', ['content' => $follow->followable]),
                    'actions' => view('component.actions', ['actions' => $follow->followable->getActions()])
                ])

        @endforeach

    @endif

@stop
