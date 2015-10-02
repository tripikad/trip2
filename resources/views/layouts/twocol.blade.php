@extends('layouts.main')

@section('content')

<div class="row">
    
  <div class="col-sm-8 utils-padding-right">

        @yield('content.left')

    </div>

  <div class="col-sm-4">
    
    @yield('content.right')

    @include('component.placeholder', [
        'text' => 'Right column',
        'height' => 300
    ])

  </div>

</div>

@stop
