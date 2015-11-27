@extends('layouts.one_column')

@section('title')
    {{ trans('message.index.title', ['user' => $user->name]) }}
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

    @if (count($user->messages()))

        @foreach ($user->messages() as $message)

            @include('component.row', [
                'profile' => [
                    'modifiers' => 'm-small',
                    'image' => $message->withUser->imagePreset(),
                    'route' => route('user.show', [$message->withUser])
                ],
                'title' => $message->title,
                'route' => route('message.index.with', [$user, $message->withUser]),
                'text' => trans('message.index.row.description', [
                    'user' => view('component.user.link', ['user' => $message->withUser]),
                    'created_at' => view('component.date.long', ['date' => $message->created_at])
                ]),
                'modifiers' => 'm-image ' . ($message->read ? 'm-blue' : 'm-green')
            ])

        @endforeach

    @endif

@stop
