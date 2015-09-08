@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('content')

    <div class="utils-border-bottom 
        @if (! $content->status)
            utils-unpublished
        @endif
    ">
        
    <div class="utils-padding-bottom">

        @include('component.card', [
            'image' => $content->imagePreset('large'),
            'options' => '-center -noshade -wide -large',
            'title' => $content->title,
        ])

    </div>

    @include('component.row', [
        'image' => $content->user->imagePreset(),
        'image_link' => route('user.show', [$content->user]),
        'text' => trans("content.show.row.text", [
            'user' => view('component.user.link', ['user' => $content->user]),
            'created_at' => $content->created_at->format('d. m Y H:i:s'),
            'updated_at' => $content->updated_at->format('d. m Y H:i:s'),
            'destinations' => $content->destinations->implode('name', ','),
            'tags' => $content->topics->implode('name', ','),
        ]),
        'actions' => view('component.actions', ['actions' => $content->getActions()]),
        'extra' => view('component.flags', ['flags' => $content->getFlags()])
    ])

    <div class="row utils-border-bottom">

        <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">

            {!! $content->body_filtered !!}

        </div>

    </div>

    <div class="utils-border-bottom">

        @include('component.comment.index', ['comments' => $comments])

    </div>

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop