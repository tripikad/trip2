@extends('layouts.main')

@section('title')

    {{ $destination->name }}

@stop

@section('header1.image')

    @if(isset($features['photo']['contents'][0]))

        {{ $features['photo']['contents'][0]->imagePreset('large') }}

    @else

        {{ $random_image }}

    @endif

@stop

@section('header2', view('component.destination.header2'))
@section('header3', view('component.destination.header3'))

@section('header2.left')

    @include('component.subheader', [
        'title' => 'Offers',
        'link_title' => 'More',
        'link_route' => '',
        'options' => '-padding -orange',
    ])

    @include('component.card', [
        'image' => $random_image2,
        'title' => 'Flightoffer A in Header 2 left column',
        'options' => '-center -wide',
    ])

    @include('component.card', [
        'image' => $random_image3,
        'title' => 'Flightoffer B in Header 2 left column',
        'options' => '-center -wide',
    ])

@stop

@section('header2.center')

    @include('component.placeholder', [
        'text' => 'Header2 center column',
    ])

@stop

@section('header2.right')
 
    @include('component.placeholder', [
        'text' => 'Header2 right column',
    ])

@stop

@section('header3.left')

    @include('component.ad',[
        'title' => 'Sample ad',
        'options' => '-high',
    ])

@stop

@section('header3.center')

    @include('component.subheader', [
        'title' => 'Header 3 subheader',
        'link_title' => '',
        'link_route' => '',
        'options' => '-orange',
    ])

    <p>This text is in the Header 3 center column. This book is a record of a pleasure trip. If it were a record of a solemn scientific expedition...</p>

@stop

@section('header3.right')
    
    @include('component.subheader', [
        'title' => 'Header 3 subheader',
        'link_title' => '',
        'link_route' => '',
        'options' => '-orange',
    ])

    <p>This book<br />Is a record<br />Of a pleasure trip</p>

@stop


@section('content')

<div class="utils-padding-bottom">

    @foreach($features as $type => $feature) 

        @include("component.content.$type.frontpage", [
            'contents' => $feature['contents']
        ])
        
    @endforeach

</div>

<div class="utils-padding-bottom">
        
    @if(count($destination->usersHaveBeen()) > 0)

        @include('component.subheader', [
            'title' => trans('destination.index.user.havebeen.title', [
                'count' => count($destination->usersHaveBeen())
            ]),
            'link_title' => '',
            'link_route' => '',
            'options' => '-orange -padding',
        ])
            
        @include('component.destination.users',
            ['users' => $destination->usersHaveBeen()]
        )

    @endif


    @if(count($destination->usersWantsToGo()) > 0)

    @include('component.subheader', [
        'title' => trans('destination.index.user.wantstogo.title', [
            'count' => count($destination->usersWantsToGo())
        ]),
        'link_title' => '',
        'link_route' => '',
        'options' => '-orange -padding',
    ])

        @include('component.destination.users',
            ['users' => $destination->usersWantsToGo()]
        )

    @endif

</div>

@stop
