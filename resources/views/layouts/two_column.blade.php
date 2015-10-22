@extends('layouts.main')

@section('content')

<div class="l-two-column">
    
    <div class="l-two-column__left">

        @yield('content.left')

    </div>

    <div class="l-two-column__right">
    
        @include('component.placeholder', [
            'text' => 'Right column',
            'height' => 300
        ])

        @yield('content.right')

  </div>

</div>

@stop
