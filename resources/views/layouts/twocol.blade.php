@extends('layouts.main')

@section('content')

<div class="row">
    
  <div class="col-sm-8">

        @yield('content.left')

    </div>

  <div class="col-sm-4 utils-padding-left">
    
    @yield('content.right')

    <div class="utils-padding-bottom">

    @include('component.destination.subheader', [
        'title' => 'Tokyo',
        'title_route' => '',
        'text' => 'Jaapan',
        'text_route' => '',
        'options' => '-orange'
    ])

    @include('component.card', [
        'image' => $random_image2,
        'title' => 'Flightoffer A in Header 2 left column',
        'options' => '-center',
    ])

    </div>

    @include('component.placeholder', [
        'text' => 'Right column',
        'height' => 300
    ])

  </div>

</div>

@stop
