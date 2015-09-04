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
        
        <div class="utils-double-padding-bottom">

            @include('component.card', [
                'image' => $image->preset('large'),
                'options' => '-center -noshade -wide -large',
                'title' => $content->title,
            ])

        </div>

    @endif

    <div class="row utils-border-bottom">

        <div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">

            {!! $content->filteredbody !!}

        </div>

    </div>

    <div class="utils-border-bottom">

    @include('component.row', [
        'image' => $content->user->preset('xsmall_square'),
        'image_link' => route('user.show', [$content->user]),
        'text' => trans("content.show.row.text", [
            'user' => view('component.user.link', ['user' => $content->user]),
            'created_at' => $content->created_at->format('d. m Y H:i:s'),
            'updated_at' => $content->updated_at->format('d. m Y H:i:s'),
            'destinations' => $content->destinations->implode('name', ','),
            'tags' => $content->topics->implode('name', ','),
        ]),
    ])

    </div>

    <div class="utils-border-bottom text-center">

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

    @include('component.comment.index', ['comments' => $comments])

    @if (\Auth::check())

        @include('component.comment.create')

    @endif

@stop