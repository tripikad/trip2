@extends('layouts.user')

@section('title')
    {{ $user->name }}
@stop

@section('action.primary')
    @include('components.placeholder', ['text' => 'Send private message'])
@stop

@section('user')

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

@stop

