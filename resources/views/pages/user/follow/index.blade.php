@extends('layouts.main')

@section('title')
    {{ trans('user.follow.index.title', ['user' => $user->name]) }}
@stop

@section('content')

@if (count($user->follows))

@foreach ($user->follows as $follow)
  
    <hr />

    @include('components.row', [
        'image' => $follow->followable->user->imagePath(),
        'image_link' => route('user.show', [$follow->followable->user]),
        'heading' => $follow->followable->title,
        'heading_link' => route('content.show', [$follow->followable->type, $follow->followable->user]),
        'text' => trans('user.follow.index.row.text', [
            'user' => view('components.user.link', ['user' => $follow->followable->user]),
            'created_at' => $follow->followable->created_at->format('d. m Y H:i:s')
        ])
    ])

@endforeach

@endif

@stop