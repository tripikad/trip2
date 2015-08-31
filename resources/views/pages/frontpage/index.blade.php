@extends('layouts.main')

@section('title')
    {{ trans('frontpage.index.search.title') }}
@stop


@section('content')

<div class="utils-border-bottom">

    @include('component.frontpage.search')

</div>


<div class="utils-border-bottom">

@foreach($features as $type => $feature) 

        @include("component.content.$type.frontpage", [
            'contents' => $feature['contents']
        ])
    
@endforeach

</div>

@stop
