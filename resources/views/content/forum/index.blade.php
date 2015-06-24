@extends('layout')

@section('title')
{{ $title }}
@stop

@section('content')

  @foreach ($contents as $content)

    <h3><a href="/content/{{ $content->id }}">{{ $content->title }}</a></h3>
    <p>
        by @include('user.item', ['user' => $content->user])
        at {{ $content->created_at->format('d.m.Y') }}
        ({{ count($content->comments) }},
        latest at {{ $content->updated_at->format('d. m Y') }})
        @include('destination.index', ['destinations' => $content->destinations])
        @include('topic.index', ['topics' => $content->topics])

    </p>
    <p>
        <small>@include('flag.show', ['flags' => $content->flags])</small>
    </p>

  @endforeach

  {!! $contents->render() !!}

@stop

