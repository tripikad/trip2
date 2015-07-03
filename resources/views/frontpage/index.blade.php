@extends('layout')

@section('content')

<div style="margin-top: -40px;">

@foreach($fronts as $type => $front) 
    {{--
    @include('component.placeholder', [
        'text' => $front['title'],
        'height' => 60
    ])
    --}}
    
    @include("content.$type.front", [
        'title' => $front['title'],
        'contents' => $front['contents']
    ])
    
    <hr />
    
@endforeach

</div>

@stop
