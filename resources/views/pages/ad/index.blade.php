@extends('layouts.main')

@section('content')

@foreach(['wide1x1', 'wide2x1', 'narrow3x1', 'widenarrow2x1', 'square4x1'] as $ad) 

    <h2>{{ $ad }}

    <hr />

    @include("components.ad.$ad")

    <hr />
    
@endforeach

@stop
