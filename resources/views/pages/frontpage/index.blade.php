@extends('layouts.main')

@section('title')
    {{ $title or ''}}
@stop

@section('content')

@foreach($fronts as $type => $front) 

    <div class="utils-border-bottom">

        @include("components.content.$type.front", [
            'contents' => $front['contents']
        ])
    
    </div>>
    
@endforeach

</div>

@stop
