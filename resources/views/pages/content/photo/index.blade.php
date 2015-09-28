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

    <div class="utils-padding-bottom">

        @include('component.filter')

    </div>

    @foreach ($contents as $content)

        <div class="row utils-padding-bottom">
                            
            <div class="col-sm-14 col-sm-offset-1 col-lg-12 col-lg-offset-2">
                    
                <a href="{{ route('content.show', [$content->type, $content]) }}">
                        
                    <img src="{{ $content->imagePreset('large') }}" />
                    
                </a>

            </div>

        </div>

        <div class="utils-padding-bottom">

            @include('component.row', [
                'image' => $content->user->imagePreset(),
                'image_link' => route('user.show', [$content->user]),
                'heading' => $content->title,
                'description' => view('component.content.description', ['content' => $content]),
                'actions' => view('component.actions', ['actions' => $content->getActions()]),
                'extra' => view('component.flags', ['flags' => $content->getFlags()]),
                'body' => $content->body_filtered,
                'options' => '-narrow'
            ])

        </div>
        
        @include('component.comment.index', [
            'comments' => $content->comments,
            'options' => '-narrow'
        ])

    @endforeach

    {!! $contents->render() !!}

@stop

