@extends('layouts.one_column')

@section('title')

    {{ trans('message.index.with.title', ['user' => $user->name, 'user_with' => $user_with->name]) }}

@stop

@section('content2.content')

    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))

        @include('component.nav', [
            'menu' => 'user',
            'items' => [
                'activity' => ['route' => route('user.show', [$user])],
                'message' => ['route' => route('message.index', [$user])],
                'follow' => ['route' => route('follow.index', [$user])]
            ],
            'options' => 'text-center'
        ])

    @endif

@stop

@section('content.one')

@if (count($messages))

@foreach ($messages as $message)

    <div id="message-{{ $message->id }}" class="utils-padding-bottom @if ($message->read) utils-read @endif">

    @include('component.row', [
        'profile' => [
            'modifiers' => '',
            'image' => $message->fromUser->imagePreset(),
            'route' => ''
        ],
        'text' => trans('message.index.with.row.description', [
            'user' => $message->fromUser->name,
            'created_at' => view('component.date.long', ['date' => $message->created_at])
        ]),
        'body' => nl2br($message->body),
        'modifiers' => '-narrow -small'
    ])

    </div>

@endforeach

@endif

    @include('component.message.create', [
        'user_from' => $user,
        'user_to' => $user_with
    ])

@stop
