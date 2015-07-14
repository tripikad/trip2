@extends('layouts.main')

@section('title')
    {{ $title or ''}}
@stop

@section('content')

@foreach($fronts as $type => $front) 

    @include("components.content.$type.front", [
        'contents' => $front['contents']
    ])
    
    <hr />
    
@endforeach

</div>

@stop
