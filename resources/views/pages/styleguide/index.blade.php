@extends('layouts.main')

@section('title')

    Styleguide

@stop

@section('content')

<div class="component-styleguide">

<mark>Text paragraphs</mark>

<p>Organic cray beard yr Tumblr lomo. Taxidermy kale chips fanny pack flannel Austin vegan iPhone, quinoa cornhole. Meh DIY kogi fingerstache squid kitsch.</p>

<p>Portland paleo post-ironic, chia cardigan cronut Schlitz. Thundercats cornhole tote bag, cray tousled messenger bag narwhal Austin Bushwick meggings.</p>

<hr />

<mark>Headings</mark>

<h2>Heading 2</h2>
Heading 2 is used in page titles

<h3>Heading 3</h3>
Heading 3 is used in item lists on pages

<h4>Heading 4</h4>
Heading 4 is used for subheadings inside longer text paragraphs

<hr />

<mark>Headings</mark>

<p>Row is meant for listings and content headers, it supports user image, content heading and subheading and extra content</p>

<br />

@include('component.row', [
    'image' => \App\User::orderByRaw('RAND()')->first()->imagePreset(),
    'image_link' => '',
    'heading' => 'Here comes the heading',
    'heading_link' => '',
    'text' => 'This is the subheading',
    'extra' => 'Extra'
])

<hr />

<mark>Card headings and styles</mark>

<div class="row">
    
    @foreach(['(none)', '-center', '-rounded', '-noshade -invert'] as $options) 

    <div class="col-sm-3">
        
        <code>{{ $options }}</code>

        @include('component.card', [
            'image' => \App\Image::orderByRaw('RAND()')->first()->preset(),
            'title' => 'Here is title',
            'text' => 'Here is subtitle',
            'options' => $options,
        ])

    </div>

    @endforeach

</div>

<hr />

<mark>Card sizes</mark>

<div class="row">
    
    @foreach(['-wide', '(none)', '-square', '-portrait'] as $options) 

    <div class="col-sm-3">
        
        <code>{{ $options }}</code>

        @include('component.card', [
            'image' => \App\Image::orderByRaw('RAND()')->first()->preset(),
            'title' => 'Here is title',
            'text' => 'Here is subtitle',
            'options' => $options,
        ])

    </div>

    @endforeach

</div>

<hr />

@foreach(['wide1x1', 'wide2x1', 'narrow3x1', 'square4x1'] as $ad) 

    <mark>{{ ucfirst($ad) }} ad</mark>

    @include("component.ad.$ad")

    <hr />

@endforeach

</div>

@stop
