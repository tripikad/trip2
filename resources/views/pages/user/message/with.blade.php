@extends('layouts.user')

@section('title')

    {{ $user->name }} messages with {{ $user_with->name }}

@stop

@section('user')

@if (count($messages))

@foreach ($messages as $message)

    @include('components.row', [
        'heading' => null,
        'image' => $message->fromUser->imagePath(),
        'text' => 'At ' . $message->created_at->format('d. m Y H:i:s')
    ])

    {!! $message->body !!}

    <hr>

@endforeach

@endif

@stop