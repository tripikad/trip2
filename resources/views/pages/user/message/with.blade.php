@extends('layouts.main')

@section('title')

    {{ trans('user.show.messages.with.title', ['user' => $user->name, 'user_with' => $user_with->name]) }}

@stop

@section('content')

@if (count($messages))

@foreach ($messages as $message)

    @include('components.row', [
        'image' => $message->fromUser->imagePath(),
        'text' => trans('user.show.messages.with.row.text', [
            'created_at' => $message->created_at->format('d. m Y H:i:s')
        ])
    ])

    {!! nl2br($message->body) !!}

    <hr>

@endforeach

@endif

@stop