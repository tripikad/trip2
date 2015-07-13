@extends('layouts.main')

@section('title')
    {{ trans('user.show.messages.index.title', ['user' => $user->name]) }}
@stop

@section('content')

@if (count($user->messages()))    

@foreach ($user->messages() as $message)
  
    @include('components.row', [
        'image' => $message->fromUser->imagePath(),
        'image_link' => route('user.show', [$message->fromUser]),
        'heading' => $message->title,
        'heading_link' => route('user.show.messages.with', [$user, $message->fromUser]),
        'text' => trans('user.show.messages.index.row.text', [
            'user' => view('components.user.link', ['user' => $message->fromUser]),
            'created_at' => $message->created_at->format('d. m Y H:i:s')
        ])
    ])

    <hr />

@endforeach

@endif

@stop