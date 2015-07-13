@extends('layouts.main')

@section('title')
    {{ $user->name }}
@stop

@section('header')
    @include('components.header.user',[
        'image' => $user->imagePath(),
        'title' => $user->name,
        'text' => trans('user.show.subheader', ['created_at' => $user->created_at->diffForHumans()])
    ])
@stop


