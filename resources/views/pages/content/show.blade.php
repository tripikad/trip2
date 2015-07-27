@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('content')

    <div class="
        @if (! $content->status)
            utils-unpublished
        @endif
    ">

    @if($content->image)
        
        <div class="utils-padding-bottom">

        @include('components.image', [
            'image' => $content->imagePath(),
        ])

        </div>

    @endif

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
        ]),
        'extra' => view('components.flag', [
            'good' => count($content->flags->where('flag_type', 'good')),
            'bad' => count($content->flags->where('flag_type', 'bad'))
        ])
    ])

    <div class="row utils-border-bottom">

        <div class="col-sm-1">
        </div>

        <div class="col-sm-10">

            {!! nl2br($content->body) !!}

        </div>
        
        <div class="col-sm-1">

            @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $content->user->id))
                
                <a href="{{ route('content.edit', ['type' => $content->type, 'id' => $content]) }}">Edit</a>
            
            @endif
        
        </div>

    </div>

    </div>
    
    @include('components.comment.index', ['comments' => $comments])

    @if (\Auth::check())

        @include('components.comment.create')

    @endif

@stop