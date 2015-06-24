@extends('layout')

@section('title')
Contents
@stop

@section('content')

  @foreach ($contents as $content)
    <p>
        <a href="/content/{{ $content->id }}">{{ $content->title }}</a>
        @include('user.show', ['user' => $content->user])
        ({{ count($content->comments) }})
        <small>@include('flag.show', ['flags' => $content->flags])</small>

    </p>
  @endforeach

  {!! $contents->render() !!}

@stop

