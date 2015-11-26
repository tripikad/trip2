@extends('layouts.one_column')

@section('title')

    {{ trans('message.index.with.title', ['user' => $user->name, 'user_with' => $user_with->name]) }}

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

@if (count($messages))

    @include('component.list', [
        'modifiers' => 'm-dark',
        'items' => $messages->transform(function ($message) {
            return [
                'id' => 'message-' . $message->id,
                'modifiers' => ($message->read ? 'm-blue' : 'm-red'),
                'title' => trans('message.index.with.row.description', [
                    'user' => $message->fromUser->name,
                    'created_at' => view('component.date.long', ['date' => $message->created_at])
                ]),
                'text' => nl2br($message->body),
                'profile' => [
                    'modifiers' => 'm-small',
                    'image' => $message->fromUser->imagePreset(),
                    'route' => ''
                ]
            ];
        })
    ])

@endif

    @include('component.message.create', [
        'user_from' => $user,
        'user_to' => $user_with
    ])

@stop
