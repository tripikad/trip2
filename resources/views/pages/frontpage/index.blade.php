@extends('layouts.main')

@section('title')
    
    {{ trans('frontpage.index.search.title') }}

@stop

@section('header1.bottom')

    @include('component.frontpage.search')

@stop

@section('header2', view('component.frontpage.header2'))

@section('header2.left')

    @include('component.destination.subheader', [
        'title' => 'Shanghai',
        'title_route' => '',
        'text' => 'China',
        'text_route' => '',
        'options' => '-orange'
    ])

    @include('component.card', [
        'image' => \App\Image::getRandom(),
        'title' => 'Crazy offer',
        'options' => '-center',
    ])

@stop

@section('header2.center')

    @include('component.destination.subheader', [
        'title' => 'Koh Lanta',
        'title_route' => '',
        'text' => 'Thailand',
        'text_route' => '',
        'options' => '-green'
    ])

    @include('component.card', [
        'image' => \App\Image::getRandom(),
        'title' => 'Crazy offer',
        'options' => '-center',
    ])

@stop

@section('header2.right')

    @include('component.destination.subheader', [
        'title' => 'Huascarán',
        'title_route' => '',
        'text' => 'Peru',
        'text_route' => '',
        'options' => '-red'
    ])

    @include('component.card', [
        'image' => \App\Image::getRandom(),
        'title' => 'Crazy offer',
        'options' => '-center',
    ])

@stop

@section('content')

<div class="row utils-padding-bottom">
    
    <div class="col-sm-3">

        @include('component.placeholder', [
            'text' => 'About',
            'height' => '300',
        ])


    </div>

    <div class="col-sm-9 utils-padding-left">

        @include('component.placeholder', [
            'text' => 'Forum',
            'height' => '300',
        ])

    </div>

</div>

<div class="row utils-padding-bottom">
    
    <div class="col-sm-3">

        @include('component.ad',[
            'title' => 'Sample wide ad',
            'options' => '-skyscraper',
        ])

    </div>

    <div class="col-sm-9 utils-padding-left">

        <div class="row utils-padding-bottom">

            <div class="col-sm-8 utils-half-padding-right">

                @include('component.placeholder', [
                    'text' => 'News1',
                    'height' => '220',
                ])
                
            </div>

            <div class="col-sm-4 utils-half-padding-left">

                @include('component.placeholder', [
                    'text' => 'News2',
                    'height' => '220',
                ])
                
            </div>

        </div>

        @include('component.placeholder', [
            'text' => 'News3',
            'height' => '110',
        ])

    </div>

</div>

<div class="row utils-padding-bottom">
    
    <div class="col-sm-7 utils-half-padding-right">

        @include('component.placeholder', [
            'text' => 'Flights',
            'height' => '220',
        ])

    </div>

    <div class="col-sm-5 utils-half-padding-left">

        @include('component.placeholder', [
            'text' => 'Blogs',
            'height' => '220',
        ])

    </div>

</div>

<div class="row utils-padding-bottom">

    @include('component.placeholder', [
        'text' => 'Travelmates',
        'height' => '100',
    ])

</div>

<div class="row utils-padding-bottom">

    @include('component.placeholder', [
        'text' => 'Photos',
        'height' => '100',
    ])

</div>

<div class="row">
    
    <div class="col-sm-8 col-sm-offset-2">
        
        @include('component.ad',[
            'title' => 'Sample wide ad',
        ])
        
    </div>

</div>

@stop