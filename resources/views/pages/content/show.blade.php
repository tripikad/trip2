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

    @if($image = $content->images()->first())
        
        <div class="utils-padding-bottom">

        @include('component.card', [
            'image' => $image->preset('large'),
            'options' => '-noshade'
        ])

        </div>

    @endif

    @include('component.row', [
        'image' => $content->user->preset('xsmall_square'),
        'image_link' => route('user.show', [$content->user]),
        'heading' => $content->title,
        'text' => trans("content.show.row.text", [
            'user' => view('component.user.link', ['user' => $content->user]),
            'created_at' => $content->created_at->format('d. m Y H:i:s'),
            'updated_at' => $content->updated_at->format('d. m Y H:i:s'),
            'destinations' => $content->destinations->implode('name', ','),
            'tags' => $content->topics->implode('name', ','),
        ]),
        'extra' => view('component.flag', [ 'flags' => [
            'good' => [
                'value' => count($content->flags->where('flag_type', 'good')),
                'flaggable' => \Auth::check(),
                'flaggable_type' => 'content',
                'flaggable_id' => $content->id,
                'flag_type' => 'good'
            ],
            'bad' => [
                'value' => count($content->flags->where('flag_type', 'bad')),
                'flaggable' => \Auth::check(),
                'flaggable_type' => 'content',
                'flaggable_id' => $content->id,
                'flag_type' => 'bad'
            ]
        ]])
    ])

    <div class="row">

        <div class="col-sm-1">
        </div>

        <div class="col-sm-10">

            {!! $content->filteredbody !!}

        </div>
        
        <div class="col-sm-1">

            @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $content->user->id))
                
                <a href="{{ route('content.edit', ['type' => $content->type, 'id' => $content]) }}">Edit</a>
            
            @endif

            @if (\Auth::check() && \Auth::user()->hasRole('admin'))
                
                <a href="{{ route('content.status', [
                    $content->type,
                    $content,
                    (1 - $content->status)
                ]) }}">

                    {{ trans('content.action.' . config("site.statuses.$content->status") . '.title') }}

                </a>

            @endif

        </div>

    </div>

    </div>
    
    @include('component.comment.index', ['comments' => $comments])

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop