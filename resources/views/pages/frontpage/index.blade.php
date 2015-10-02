@extends('layouts.main')

@section('title')
    {{ trans('frontpage.index.search.title') }}
@stop

@section('header2', view('component.frontpage.header2'))

@section('header2.left')

    @include('component.destination.subheader', [
        'title' => $random_destination,
        'title_route' => '',
        'text' => $random_destination,
        'text_route' => '',
        'options' => '-orange'
    ])

    @include('component.card', [
        'image' => $random_image,
        'title' => 'Crazy offer to ' . $random_destination,
        'options' => '-center -wide',
    ])

@stop

@section('header2.center')

    @include('component.destination.subheader', [
        'title' => $random_destination2,
        'title_route' => '',
        'text' => $random_destination2,
        'text_route' => '',
        'options' => '-green'
    ])

    @include('component.card', [
        'image' => $random_image2,
        'title' => 'Crazy offer to ' . $random_destination2,
        'options' => '-center -wide',
    ])

@stop

@section('header2.right')

    @include('component.destination.subheader', [
        'title' => $random_destination3,
        'title_route' => '',
        'text' => $random_destination3,
        'text_route' => '',
        'options' => '-red'
    ])

    @include('component.card', [
        'image' => $random_image3,
        'title' => 'Crazy offer to ' . $random_destination3,
        'options' => '-center -wide',
    ])

@stop

@section('content')

@foreach($features as $type => $feature) 

        @include("component.content.$type.frontpage", [
            'contents' => $feature['contents']
        ])
    
@endforeach

@stop
--}}
