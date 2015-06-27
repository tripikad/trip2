@extends('layout')

@section('title')
  {{ $content->title }}
@stop

@section('content')

    <div class="row">

        <div class="col-sm-1">

            <a href="/user/{{ $content->user->id }}">
                @include('image.circle', ['image' => $content->user->imagePath()])
            </a>

        </div>

        <div class="col-sm-10">

            <p>@include('user.item', ['user' => $content->user])</p>

            <big>{!! nl2br($content->body) !!}</big>

        </div>

        <div class="col-sm-1">
        
            <small>@include('flag.show', ['flags' => $content->flags])</small>

        </div>

    </div>

  @include('comment.index', ['comments' => $content->comments])

@stop
