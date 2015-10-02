@extends('layouts.main')

@section('title')

    Header1 title

@stop

@section('header2.left')

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

    @include('component.card', [
        'image' => $random_image,
        'text' => 'Ad 1'
    ])

@stop

@section('header3.center')

    <h3>Subheader in Header 3 center</h3>

    <p>This text is in the Header 3 center column. This book is a record of a pleasure trip. If it were a record of a solemn scientific expedition...</p>

@stop

@section('header3.right')
    
    <h3>Subheader in header 3 right</h3>

    <p>This book<br />Is a record<br />Of a pleasure trip</p>

@stop

@section('content')

<div class="component-styleguide">

<mark>Text paragraphs</mark>

<p>This book is a record of a pleasure trip. If it were a record of a solemn scientific expedition, it would have about it that gravity, that profundity, and that impressive incomprehensibility which are so proper to works of that kind, and withal so attractive.</p>

<p>Yet notwithstanding it is only a record of a <a href="https://en.wikipedia.org/wiki/Picnic">pic-nic</a>, it has a purpose, which is to suggest to the reader how he would be likely to see Europe and the East if he looked at them with his own eyes instead of the eyes of those who traveled in those countries  <em>before</em> him. I make small pretense of showing anyone how he ought to look at objects of interest beyond the sea — <strong>other books</strong> do that, and therefore, even if I were competent to do it, there is no need.</p>


<mark>Headings</mark>

<h1>Heading 1</h1>
<p>Heading 1 is used for large page title</p>

<h2>Heading 2</h2>
<p>Heading 2 is used for smaller page title</p>

<h3>Heading 3</h3>
<p>Heading 4 is used for subheadings on a page</p>

<h4>Heading 4</h4>
<p>Heading 3 is used in item lists titles on pages</p>

<h5>Heading 5</h5>
<p>Heading 4 is used for subheadings between text paragraphs</p>


<mark>Placeholder and separators</mark>

<p>Placeholder is meant for prototyping components not yet created. It accepts height parameter for specifying component height in pixels.</p>

<p>To seprate components from each other, <code>.utils-padding-bottom</code> and <code>.utils-border-bottom</code> wrapper classes are provided, they set bottom spacing between components.</p>

<div class="utils-padding-bottom">

    @include('component.placeholder', [
        'text' => 'Placeholder',
    ])

</div>

<div class="utils-border-bottom">

    @include('component.placeholder', [
        'text' => 'Placeholder separated with spacer',
    ])

</div>

@include('component.placeholder', [
    'text' => 'Placeholder separated with border',
])

<mark>Grid</mark>

<div class="row" style="border-left: 1px solid gray;">
    
    @for ($i = 1; $i < 13; $i++)

        <div class="col-sm-1 text-center" style="border-right: 1px solid gray;">

            {{ $i }}

        </div>

    @endfor

</div>

{{--

<p>When columns contain uneven amount of content, use <code>.utils-equal-height</code> on <code>.row</code> element for equal height columns.</p>

@foreach(['', 'utils-equal-height'] as $options) 

<div class="row {{ $options }}" style="border-left: 1px solid gray;">
    
    @for ($i = 1; $i < 17; $i++)

        <div class="col-sm-1 text-center" style="border-right: 1px solid gray;">
        
            {{ ['Some', 'Some text', 'Some more text'][rand(0,2)] }}

        </div>

    @endfor

</div>

<br />

@endforeach
--}}

<mark>Menu</mark>

@include('component.menu', [
    'menu' => 'styleguide',
    'items' => [
        'first' => [
            'route' => ''
        ],
        'second' => [
            'route' => ''
        ],
        'third' => [
            'route' => ''
        ]
    ]
])

<br />

<mark>Numbers</mark>

<p>Any properties can be combined. Numbers fill proportionally their container width.</p>


@foreach(['', '-small'] as $index => $options1) 

<div class="row">

    @foreach(['(none)', '-good', '-bad', '-neutral', '-orange'] as $options2) 

        <div class="col-xs-1">

            <p><code>{{ $options2 }} {{ $options1 }}</code></p>
            
            <div class="row">

                <div class="col-xs-8">

                    @include('component.number', [
                        'number' => '1',
                        'options' => $options2 . ' ' . $options1
                    ])
                    
                </div>

            </div>

        </div>    

    @endforeach

</div>

<br />

@endforeach

<mark>Labels</mark>

<p>Set labels on content titles etc.</p>

@include('component.label', [
    'title' => 'This is label'
])

<br />

<mark>Actions</mark>

<p>Set of actions on content elements, usually for admins. Keep the titles short!</p>

@include('component.actions', [
    'actions' => [
        ['route' => '', 'title' => 'First'],
        ['route' => '', 'title' => 'Second'],
        ['route' => '', 'title' => 'Third']
    ]
])

<br />

<mark>User image component</mark>

<div class="row">
    
    @foreach(['(none)', '-circle'] as $options) 

        <div class="col-xs-1">
            
            <p><code>{{ $options }}</code></p>
            
            @include('component.user.image', [
                'image' => \App\User::orderByRaw('RAND()')->first()
                    ? \App\User::orderByRaw('RAND()')->first()->imagePreset()
                    : null,
                'options' => $options,
            ])

        </div>

    @endforeach

</div>

<mark>Row component</mark>

<p>Row is meant for listings and content headers,</p>

@include('component.row', [
    'image' => \App\User::orderByRaw('RAND()')->first()
        ? \App\User::orderByRaw('RAND()')->first()->imagePreset()
        : null,
    'image_link' => '',
    'preheading' => view('component.label', [
        'title' => 'Label'
    ]),
    'heading' => 'This is heading',
    'heading_link' => '',
    'postheading' => view('component.label', [
        'title' => 'Label'
    ]),
    'actions' => view('component.actions', [
        'actions' => [
            ['route' => '', 'title' => 'This is first action'],
            ['route' => '', 'title' => 'This is second action'],
        ]
    ]),
    'description' => 'This is the description',
    'extra' => 'Extra',
    'body' => 'This book is a record of a pleasure trip. If it were a record of a solemn scientific expedition, it would have about it that gravity, that profundity, and that impressive incomprehensibility which are so proper to works of that kind, and withal so attractive.',
    'options' => $options
])


<mark>Card component</mark>

<p>Any card properties can be combined. Cards fill proportionally their container width.</p>

<div class="row">
    
    @foreach(['(none)', '-center', '-noshade', '-noshade -invert', '-square', '-wide'] as $options) 

    <div class="col-sm-4">
        
        <br /><code>{{ $options }}</code><p />

        @include('component.card', [
            'image' => $random_image,
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

{{--

@foreach(['wide1x1', 'wide2x1', 'narrow3x1', 'square4x1'] as $ad) 

    <mark>{{ ucfirst($ad) }} ad</mark>

    @include("component.ad.$ad")

@endforeach

--}}

</div>

@stop
