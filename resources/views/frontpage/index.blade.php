@extends('layout')

@section('content')

<div style="margin-top: -40px;">

@foreach($fronts as $type => $front) 

    <div style="margin: 30px 0 0 0;">

        @include('component.placeholder', ['text' => $front['title']])

    </div>

    @include("content.$type.front", [
        'title' => $front['title'],
        'contents' => $front['contents']
    ])

@endforeach

</div>

@stop
