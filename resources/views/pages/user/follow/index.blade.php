@extends('layouts.main')

@section('title')
    {{ trans('user.follow.index.title', ['user' => $user->name]) }}
@stop

@section('navbar.bottom')
    
    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))
        
        <div class="utils-border-bottom">
            
            @include('component.user.menu', ['user' => $user])
        
        </div>

    @endif

@stop

@section('content')

@if (count($user->follows))

@foreach ($user->follows as $follow)
  
    <div class="utils-border-bottom">

        @include('component.row', [
            'image' => $follow->followable->user->imagePath(),
            'image_link' => route('user.show', [$follow->followable->user]),
            'heading' => $follow->followable->title,
            'heading_link' => route('content.show', [
                $follow->followable->type,
                $follow->followable->user
            ]),
            'text' => trans('user.follow.index.row.text', [
                'user' => view('component.user.link', ['user' => $follow->followable->user]),
                'created_at' => $follow->followable->created_at->format('d. m Y H:i:s')
            ])
        ])

    </div>

@endforeach

@endif

@stop