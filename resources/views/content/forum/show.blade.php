@extends('layout')

@section('title')
  {{ $content->title }}
@stop

@section('content')

  <p>@include('user.show', ['user' => $content->user])</p>

  {!! nl2br($content->body) !!}

  @include('comment.index', ['comments' => $content->comments])

@stop
