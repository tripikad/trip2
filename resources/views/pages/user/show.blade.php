@extends('layouts.medium')

@section('title')
    {{ $user->name }}
@stop

@section('header.top')
    @include('component.image', [
        'image' => $user->imagePath(),
        'options' => '-circle',
        'width' => '30%'
    ])
@stop

@section('header.bottom')
   <p>
    {{ trans('user.show.joined', [
        'created_at' => $user->created_at->diffForHumans()
    ]) }}
    </p>

    @if (\Auth::check() && \Auth::user()->id !== $user->id)

        @include('component.button', [ 
            'route' => route('user.show.messages.with', [
                \Auth::user(),
                $user,
                '#message'
            ]),
            'title' => trans('user.show.message.create')
        ])

    @endif

    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $user->id))

        @include('component.button', [ 
            'route' => route('user.edit', [$user]),
            'title' => trans('user.edit.title')
        ])

    @endif

@stop


@section('content.medium')
    
    <div class="utils-border-bottom">

    @include('component.user.count', [
        'content_count' => $content_count,
        'comment_count' => $comment_count
    ])

    </div>

    <div class="utils-padding-bottom">

    @include('component.user.activity', [
        'items' => $items
    ])

    </div>

@stop
