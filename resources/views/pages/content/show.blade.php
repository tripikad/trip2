@extends('layouts.main')

@section('title')
    {{ $title }}
@stop

@section('actions.primary')
    @include('components.placeholder', ['text' => 'Follow post'])
@stop

@section('content')

    <div style="style="margin-bottom: 16px;">

    @include('components.row', [
        'image' => $content->user->imagePath(),
        'image_link' => '/user/' . $content->user->id,
        'heading' => $content->title,
        'heading_link' => '/content/' . $content->id,
        'text' => 'By <a href="/user/' . $content->user->id .'">'
            . $content->user->name
            . '</a> created at '
            . $content->created_at->format('d. m Y H:i:s')
    ])

    </div>

    <div class="row"">

        <div class="col-sm-1">
        </div>

        <div class="col-sm-10">

            {!! $content->body !!}

        </div>
        
        <div class="col-sm-1">

            <a href="{{ route('content.edit', ['type' => $content->type, 'id' => $content]) }}">Edit</a>

        </div>

    </div>

    <hr />
    
    @include('components.comment.index', ['comments' => $content->comments])

    @include('components.comment.add')

@stop