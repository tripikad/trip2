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

        <div class="utils-border-bottom">

            <div class="row utils-padding-bottom">

                <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">

                    <div class="utils-padding-bottom">

                    <a href="{{ route('content.show', [$content->type, $content]) }}">
                        
                        <img src="{{ $content->imagePreset('large') }}" />
                    
                    </a>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="
                    col-sm-10 col-sm-offset-1
                    @if (count($content->comments))
                        utils-border-bottom
                    @endif
                ">

                    @include('component.row', [
                        'image' => $content->user->imagePreset(),
                        'image_link' => route('user.show', [$content->user]),
                        'heading' => $content->title,
                        'text' => view('component.content.text', ['content' => $content]),
                        'actions' => view('component.actions', ['actions' => $content->getActions()]),
                        'extra' => view('component.flags', ['flags' => $content->getFlags()])
                    ])

                    {!! $content->body_filtered !!}

                </div>

            </div>

            <div class="row">

                <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">

                @include('component.comment.index', ['comments' => $content->comments])

                </div>

            </div>

        </div>

    @endforeach


    {!! $contents->render() !!}

@stop

