@extends('layouts.main')

@section('title')
    {{ $title or ''}}
@stop

@section('content')

<div class="utils-border-bottom">

@foreach($fronts as $type => $front) 

        @include("component.content.$type.front", [
            'contents' => $front['contents']
        ])
    
@endforeach

</div>

@stop
