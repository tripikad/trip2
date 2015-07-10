@extends('layouts.main')

@section('title')
    {{ $user->name }}
@stop

@section('header')
    @include('components.header.user',[
        'image' => $user->imagePath(),
        'title' => $user->name,
        'text' => 'Joined ' . $user->created_at->diffForHumans()
    ])
@stop


