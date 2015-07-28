@extends('layouts.main')

@section('title')
    {{ $user->name }}
@stop

@section('header.top')
    @include('components.image', [
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
@stop

@section('header.right')

    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('admin', $user->id))

        @include('components.button', [ 
            'route' => route('user.edit', [$user]),
            'title' => trans('user.edit.title')
        ])

    @endif

@stop

@section('content')
    
    <div class="utils-border-bottom">

    @include('components.user.number',[
        'forum' => $number_forum,
        'comment' => $number_comment
    ])

    </div>
    
@stop
