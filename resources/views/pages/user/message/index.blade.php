@extends('layouts.user')

@section('title')
    {{ $user->name }} messages
@stop

@section('user')

@if (count($user->messages()))    

@foreach ($user->messages() as $message)
  
    @include('components.row', [
        'image' => $message->fromUser->imagePath(),
        'image_link' => '/user/' . $message->fromUser->id,
        'heading' => $message->title,
        'heading_link' => '/user/' . $user->id . '/messages/' . $message->fromUser->id,
        'text' => 'By <a href="/user/' . $message->fromUser->id .'">'
            . $message->fromUser->name
            . '</a> at '
            . $message->created_at->format('d. m Y H:i:s'),
    ])

    <hr />

@endforeach

@endif

@stop