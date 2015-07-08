@extends('layouts.main')

@section('title')
    {{ $user->name }}
@stop

@section('action.primary')
    @include('components.placeholder', ['text' => 'Send message'])
@stop

@section('action.secondary')
    @include('components.placeholder', ['text' => 'Follow'])
@stop

@section('hero')
    @include('components.hero.user',[
        'image' => $user->imagePath(),
        'title' => $user->name,
        'text' => 'Joined ' . $user->created_at->diffForHumans()
    ])
@stop


