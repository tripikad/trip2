@extends('layout')

@section('title')

    {{ $user->name }}

@stop

@section('content')

    <p>{{ $user->created_at->diffForHumans() }}</p>

@stop

