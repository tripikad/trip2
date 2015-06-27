@extends('layout')

@section('title')

    {{-- $user->name --}}

@stop

@section('content')

    <div class="text-center">
        
        <div class="center-block" style="width: 100px;">
            @include('user.image', ['user' => $user, 'nolink' => true])
        </div>
        
        <h2>{{ $user->name }}</h2>
        <p>Joined {{ $user->created_at->diffForHumans() }}</p>
    
    </div>


@stop

