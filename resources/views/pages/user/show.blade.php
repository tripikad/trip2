@extends('layouts.user')

@section('title')
    {{ $user->name }}
@stop

@section('byline')
    Joined {{ $user->created_at->diffForHumans() }}
@stop

@section('user')

@stop

