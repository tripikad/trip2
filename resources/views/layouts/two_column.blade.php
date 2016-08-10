@extends('layouts.main')
@section('content')
    @include('component.masthead')
    <div class="l-two-column">
        <div class="l-two-column__left">
            @yield('content.one')
        </div>
        <div class="l-two-column__right">
            @include('component.placeholder', [
                'text' => 'Right column',
                'height' => 300
            ])
            @yield('content.two')
      </div>
    </div>
@stop
