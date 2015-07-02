@extends('layout')

@section('title')
{{ $title }}
@stop

@section('action.primary')
    @include('component.placeholder', ['text' => '＋ Add new blog post'])
@stop

@section('content')

  
    @foreach ($contents as $content)

        <div class="row">

            <div class="col-xs-2">
                
                <a href="/user/{{ $content->user->id }}">
                    @include('image.circle', ['image' => $content->user->imagePath()])
                </a>
          
            </div>
            
            <div class="col-xs-10">
                
                <h3><a href="/content/{{ $content->id }}">{{ $content->title }}</a></h3>
                
                <p>
                by @include('user.item', ['user' => $content->user])
                at {{ $content->created_at->format('d.m.Y') }}
                ({{ count($content->comments) }},
                latest at {{ $content->updated_at->format('d. m Y') }})
                @include('destination.index', ['destinations' => $content->destinations])
                @include('topic.index', ['topics' => $content->topics])
                </p>

                {!! nl2br($content->body) !!}
            
            </div>

        </div>
        <hr />
    @endforeach

  {!! $contents->render() !!}

@stop

