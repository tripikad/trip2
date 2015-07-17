@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('actions.primary')
    @include('components.placeholder', ['text' => 'Follow post'])
@stop

@section('content')

    @if($content->image)
        
        <div style="margin-bottom: 14px;">

        @include('components.image.landscape', [
            'image' => $content->imagePath(),
        ])

        </div>

    @endif

    <div style="style="margin-bottom: 16px;">

    @include('components.row', [
        'image' => $content->user->imagePath(),
        'image_link' => route('user.show', [$content->user]),
        'heading' => $content->title,
        'text' => trans("content.show.row.text", [
            'user' => view('components.user.link', ['user' => $content->user]),
            'created_at' => $content->created_at->format('d. m Y H:i:s'),
            'updated_at' => $content->updated_at->format('d. m Y H:i:s'),
            'destinations' => $content->destinations->implode('name', ','),
            'tags' => $content->topics->implode('name', ','),
        ])
    ])

    </div>

    <div class="row"">

        <div class="col-sm-1">
        </div>

        <div class="col-sm-10">

            {!! nl2br($content->body) !!}

        </div>
        
        <div class="col-sm-1">

            <a href="{{ route('content.edit', ['type' => $content->type, 'id' => $content]) }}">Edit</a>

        </div>

    </div>

    <hr />
    
    @include('components.comment.index', ['comments' => $content->comments])

    @include('components.comment.create')

@stop