@php

$title = $title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$promobar = $promobar ?? '';
$color = $color ?? '';
$background = $background ?? '';
$header = $header ?? '';
$head_title = $head_title ?? ''; // ?
$top = $top ? collect($top) : collect();
$content = $content ? collect($content) : collect();
$sidebar = $sidebar ? collect($sidebar) : collect();
$bottom1 = isset($bottom1) ? collect($bottom1) : collect();
$bottom2 = isset($bottom2) ? collect($bottom2) : collect();
$bottom3 = isset($bottom3) ? collect($bottom3) : collect();
$footer = $footer ?? '';

@endphp

@extends('layouts.main')

@section('title', $title)
@section('head_title', $head_title)
@section('head_description', $head_description)
@section('head_image', $head_image)

@section('color', $color)
@section('background')
    {!! $background !!}
@endsection

@section('header')

<header class="Frontpage__header">

    {!! $header !!}

    @if ($top->count())

    <div class="Frontpage__topWrapper">

        <div class="Frontpage__top">

        @foreach ($top as $top_item)

            <div class="Frontpage__topItem">

            {!! $top_item !!}
                
            </div>

        @endforeach

        </div>

    </div>

    @endif

</header>

@endsection

@section('content')

<div class="Frontpage_outerContainer">

    <div class="container">

        <div class="Frontpage__innerContainer">

            <main class="Frontpage__content">

                @foreach ($content as $content_item)
                
                <div class="Frontpage__contentItem">

                    {!! $content_item !!}
                        
                </div>

                @endforeach

            </main>

            <aside class="Frontpage__sidebar">

                @foreach ($sidebar as $sidebar_item)
                            
                <div class="Frontpage__sidebarItem">

                    {!! $sidebar_item !!}
                        
                </div>

                @endforeach

            </aside>

        </div>

    </div>

</div>

<section class="Frontpage__bottom1">

    <div class="container">

        @foreach ($bottom1 as $bottom1_item)
        
            <div class="Frontpage__bottom1Item">

                {!! $bottom1_item !!}
                    
            </div>
                
        @endforeach

    </div>
    
</section>

<section class="Frontpage__bottom2">

    @foreach ($bottom2 as $bottom2_item)
    
        <div class="Frontpage__bottom2Item">

            {!! $bottom2_item !!}
                
        </div>
            
    @endforeach
    
</section>

<section class="Frontpage__bottom3">

    <div class="container">

        @foreach ($bottom3 as $bottom3_item)
        
            <div class="Frontpage__bottom3Item">

                {!! $bottom3_item !!}
                    
            </div>
                
        @endforeach

    </div>
    
</section>

@endsection

@section('footer')

    <footer class="Frontpage__footer">

    {!! $footer !!}

    </footer>

@endsection