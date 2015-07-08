@extends('layouts.main')

@section('subheader')
    
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

    <h2>@yield('title')</h2>
    
@stop

@section('content')

    @yield('user')

@stop
