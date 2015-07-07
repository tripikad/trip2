@extends('layouts.main')

@section('title')

@stop

@section('action.primary')
    @include('components.placeholder', ['text' => 'Send private message'])
@stop

@section('content')

    <div class="row">

        <div class="col-xs-4 col-sm-5">
        </div>
  
        <div class="col-xs-4 col-sm-2">

            <a href="/user/{{ $user->id }}">
                @include('components.image.circle', ['image' => $user->imagePath()])
            </a>

        </div>

        <div class="col-xs-4 col-sm-5">
        </div>

    </div>

    <div class="text-center">

        <h2>{{ $user->name }}</h2>

        <p>Joined {{ $user->created_at->diffForHumans() }}</p>
        
    </div>

    @include('components.message.index', ['messages' => $user->messages()])

    @include('components.follow.index', ['follows' => $user->follows])


@stop

