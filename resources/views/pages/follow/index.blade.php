@extends('layouts.main')

@section('title')
    {{ trans('follow.index.title', ['user' => $user->name]) }}
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
            'image' => $follow->followable->user->imagePreset(),
            'image_link' => route('user.show', [$follow->followable->user]),
            'heading' => $follow->followable->title,
            'heading_link' => route('content.show', [
                $follow->followable->type,
                $follow->followable
            ]),
            'text' => trans('follow.index.row.text', [
                'user' => view('component.user.link', ['user' => $follow->followable->user]),
                'created_at' => view('component.date.long', ['date' => $follow->followable->created_at])
            ])
        ])

    </div>

@endforeach

@endif

@stop