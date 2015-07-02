@extends('layout')

@section('title')
  {{ $title }}
@stop

@section('action.primary')
    @include('component.placeholder', ['text' => 'Follow post'])
@stop

@section('content')

    <div class="row">

        <div class="col-xs-2 col-sm-1">

            <a href="/user/{{ $content->user->id }}">
                @include('image.circle', ['image' => $content->user->imagePath()])
            </a>

        </div>

        <div class="col-xs-9 col-sm-10">
            
            <h3><a href="/content/{{ $content->id }}">{{ $content->title }}</a></h3>
            
            <p>By
                <a href="/user/"{{ $content->user->id }}">
                    {{ $content->user->name }}
                </a>
                at {{ $content->updated_at->format('d. m Y H:i:s') }}
            </p>

            <big>{!! nl2br($content->body) !!}</big>

        </div>

        <div class="col-sm-1">
        
            <small>@include('flag.show', ['flags' => $content->flags])</small>

        </div>

    </div>

  @include('comment.index', ['comments' => $content->comments])
  
  @include('comment.add')

@stop
