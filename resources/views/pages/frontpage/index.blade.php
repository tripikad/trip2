@extends('layouts.main')

@section('title')
    {{ trans('frontpage.index.search.title') }}
@stop


@section('content')

<div class="utils-border-bottom">

    @include('component.frontpage.search')

</div>


<div class="utils-border-bottom">

@foreach($fronts as $type => $front) 

        @include("component.content.$type.front", [
            'contents' => $front['contents']
        ])
    
@endforeach

</div>

@stop
