@extends('layouts.one_column')

@section('title')
    
    {{ trans('follow.index.title', ['user' => $user->name]) }}

@stop

@section('header2.content')
    
    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))
                    
        @include('component.menu', [
            'menu' => 'user',
            'items' => [
                'activity' => ['route' => route('user.show', [$user])],
                'message' => ['route' => route('message.index', [$user])],
                'follow' => ['route' => route('follow.index', [$user])]
            ],
            'options' => 'text-center'
        ])
        
    @endif

@stop

@section('content.one')

    @if (count($user->follows))

    @foreach ($user->follows as $follow)
      
        <div class="utils-padding-bottom">

            @include('component.row', [
                'image' => $follow->followable->user->imagePreset(),
                'image_link' => route('user.show', [$follow->followable->user]),
                'heading' => $follow->followable->title,
                'heading_link' => route('content.show', [
                    $follow->followable->type,
                    $follow->followable
                ]),
                'description' => view('component.content.description', ['content' => $follow->followable]),
                'actions' => view('component.actions', ['actions' => $follow->followable->getActions()]),

            ])

        </div>

    @endforeach

    @endif

@stop