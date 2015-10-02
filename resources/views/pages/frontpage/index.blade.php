@extends('layouts.main')

@section('title')
    {{ trans('frontpage.index.search.title') }}
@stop


@section('header1.bottom')

    @include('component.frontpage.search')

@stop

@section('header4')

    @include('component.frontpage.header4')

@stop

@section('content')

@foreach($features as $type => $feature) 

        @include("component.content.$type.frontpage", [
            'contents' => $feature['contents']
        ])
    
@endforeach

@stop
