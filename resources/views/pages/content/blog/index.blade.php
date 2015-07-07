@extends('layouts.main')

@section('title')
{{ $title }}
@stop

@section('action.primary')
    @include('components.placeholder', ['text' => '＋ Add new blog post'])
@stop

@section('content')

  
    @foreach ($contents as $content)

        <div class="row">

            <div class="col-xs-2">
                
                <a href="/user/{{ $content->user->id }}">
                    @include('components.image.circle', ['image' => $content->user->imagePath()])
                </a>
          
            </div>
            
            <div class="col-xs-10">
                
                <h3><a href="/content/{{ $content->id }}">{{ $content->title }}</a></h3>
                
                <p>
                by {{ $content->user->name }}
                at {{ $content->created_at->format('d.m.Y') }}
                ({{ count($content->comments) }},
                latest at {{ $content->updated_at->format('d. m Y') }})
                @include('components.destination.list', ['destinations' => $content->destinations])
                @include('components.topic.list', ['topics' => $content->topics])
                </p>

                {!! nl2br($content->body) !!}
            
            </div>

        </div>

        <hr />
        
    @endforeach

  {!! $contents->render() !!}

@stop

