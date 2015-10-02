@extends('layouts.medium')

@section('title')

    {{ trans('message.index.with.title', ['user' => $user->name, 'user_with' => $user_with->name]) }}

@stop

@section('navbar.bottom')
    
    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))
        
        <div class="utils-border-bottom">
            
            @include('component.menu', [
                'menu' => 'user',
                'items' => [
                    'activity' => ['route' => route('user.show', [$user])],
                    'message' => ['route' => route('message.index', [$user])],
                    'follow' => ['route' => route('follow.index', [$user])]
                ],
                'options' => 'text-center'
            ])
                    
        </div>

    @endif

@stop

@section('content.medium')

@if (count($messages))

@foreach ($messages as $message)

    <div

        id="message-{{ $message->id }}"
        class="utils-padding-bottom @if ($message->read) utils-read @endif"

    >

    @include('component.row', [
        'image' => $message->fromUser->imagePreset(),
        'description' => trans('message.index.with.row.description', [
            'user' => $message->fromUser->name,
            'created_at' => view('component.date.long', ['date' => $message->created_at])
        ]),
        'body' => nl2br($message->body),
        'options' => '-narrow -small'
    ])

    </div>

@endforeach

@endif

    @include('component.message.create', [
        'user_from' => $user,
        'user_to' => $user_with
    ])

@stop