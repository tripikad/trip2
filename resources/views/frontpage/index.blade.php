@extends('layout')

@section('content')

<div style="margin-top: -40px;">

@foreach($fronts as $type => $front) 

    <h2 style="
        margin: 1em 0 1.5em 0;
        text-align: center;
        font-size: 26px;
    ">
    {{ $front['title'] }}
    </h2>

    @include("content.$type.front", [
        'title' => $front['title'],
        'contents' => $front['contents']
    ])

@endforeach

</div>

@stop
