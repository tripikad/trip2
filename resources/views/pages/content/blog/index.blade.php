@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('header.right')
    @include('component.button', [ 
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])
@stop

@section('content')
    
    <div class="utils-border-bottom">

        @include('component.filter')

    </div>

    @foreach ($contents as $content)

        <div class="row utils-border-bottom">

            <div class="col-xs-2">
                
                <a href="{{ route('user.show', [$content->user]) }}">
                    @include('component.image', [
                        'image' => $content->user->imagePreset(),
                        'options' => '-circle'
                    ])
                </a>
          
            </div>
            
            <div class="col-xs-10">
                
                <div class="utils-padding-bottom">
                
                    <h3>
                        <a href="{{ route('content.show', [$content->type, $content]) }}">
                            {{ $content->title }}
                        </a>
                    </h3>
                    
                    @include('component.content.text', ['content' => $content])

                </div>
                
                {!! $content->body_filtered !!}
            
            </div>

        </div>
        
    @endforeach

  {!! $contents->render() !!}

@stop

