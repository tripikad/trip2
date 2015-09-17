@extends('layouts.main')

@section('title')

    Styleguide

@stop

@section('content')

<div class="component-styleguide">

<mark>Text paragraphs</mark>

<p>Organic cray beard Tumblr lomo. <strong>strong</strong> or <b>b</b> chips fanny pack flannel Austin vegan iPhone, quinoa cornhole. Meh DIY kogi fingerstache squid kitsch.</p>

<p>Portland paleo post-ironic, chia cardigan cronut Schlitz. <a href="">Thundercats</a> cornhole tote bag, cray <em>em</em> or <i>i</i> tousled messenger bag narwhal Austin Bushwick meggings.</p>

<mark>Headings</mark>

<h2>Heading 2</h2>
Heading 2 is used in page titles

<h3>Heading 3</h3>
Heading 3 is used in item lists on pages

<h4>Heading 4</h4>
<p>Heading 4 is used for subheadings</p>

<mark>Menu</mark>

<p>Horizontal menus</p>

@include('component.menu', [
    'menu' => 'styleguide',
    'items' => [
        'first' => [
            'url' => ''
        ],
        'second' => [
            'url' => ''
        ],
        'third' => [
            'url' => ''
        ]
    ]
])

<br />

<mark>Actions</mark>

<p>Set of actions on content elements, usually for admins. Keep the labels short!</p>

@include('component.actions', [
    'actions' => [
        ['route' => '', 'title' => 'First'],
        ['route' => '', 'title' => 'Second'],
        ['route' => '', 'title' => 'Third']
    ]
])

<br />

<mark>Row component</mark>

<p>Row is meant for listings and content headers, it supports (user) image, heading, subheading and extra content</p>

<br />

@include('component.row', [
    'image' => \App\User::orderByRaw('RAND()')->first()->imagePreset(),
    'image_link' => '',
    'heading' => 'Here comes the heading',
    'heading_link' => '',
    'actions' => view('component.actions', [
        'actions' => [
            ['route' => '', 'title' => 'Action'],
        ]
    ]),
    'text' => 'This is the subheading',
    'extra' => 'Extra'
])

<mark>Number component</mark>

<p>...</p>


<mark>Circle component</mark>

<p>...</p>


<mark>Card component</mark>

<p>Any card properties can be combined. Cards fill proportionally their container width.</p>

<div class="row">
    
    @foreach(['(none)', '-center', '-noshade', '-noshade -invert'] as $options) 

    <div class="col-sm-3">
        
        <code>{{ $options }}</code>

        @include('component.card', [
            'image' => \App\Content::whereType('photo')
                ->orderByRaw('RAND()')
                ->first()
                ->imagePreset(),
            'title' => 'Here is title',
            'text' => 'Here is subtitle',
            'options' => $options,
        ])

    </div>

    @endforeach

</div>

<div class="row">
    
    @foreach(['-wide', '-square', '-portrait', '-rounded'] as $options) 

    <div class="col-sm-3">
        
        <code>{{ $options }}</code>

        @include('component.card', [
            'image' => \App\Content::whereType('photo')
                ->orderByRaw('RAND()')
                ->first()
                ->imagePreset(),
            'title' => 'Here is title',
            'text' => 'Here is subtitle',
            'options' => $options,
        ])

    </div>

    @endforeach

</div>


<mark>Icons</mark>

<br />

@foreach([
        'ticket', 'tent', 'sunglasses', 'plane', 'passport', 
        'mobile', 'lantern', 'compass', 'backpack'
    ] as $icon) 

    @include('component.icon', [
        'icon' => $icon,
    ])

@endforeach

<br />

@foreach(['wide1x1', 'wide2x1', 'narrow3x1', 'square4x1'] as $ad) 

    <mark>{{ ucfirst($ad) }} ad</mark>

    @include("component.ad.$ad")

@endforeach

</div>

@stop
