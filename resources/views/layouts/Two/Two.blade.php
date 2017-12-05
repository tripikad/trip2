@php

$title = $title ?? '';
$head_title = $head_title ?? '';
$head_description = $head_description ?? '';
$head_image = $head_image ?? '';
$color = $color ?? '';
$background = $background ?? '';
$header = $header ?? '';
$top = isset($top) ? collect($top) : collect();
$sidebar_top = isset($sidebar_top) ? collect($sidebar_top) : collect();
$content = isset($content) ? collect($content) : collect();
$sidebar = isset($sidebar) ? collect($sidebar) : collect();
$bottom = isset($bottom) ? collect($bottom) : collect();
$footer = $footer ?? '';
$narrow = $narrow ?? false;

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

<header class="Two__header">

    {!! $header !!}

    @if ($top->count())

    <div class="Two__top">

    @foreach ($top as $top_item)

        {!! $top_item !!}
            
    @endforeach

    </div>

    @endif

</header>

@endsection

@section('content')

<div class="
    Two__contentOuterContainer
    @if($sidebar->isEmpty())
        Two--noSidebar
    @endif
">

    <div class="container">

        <div class="Two__contentInnerContainer">

            <main class="Two__content">

                @if($sidebar_top->isNotEmpty())

                    <div class="Two__sidebarTop">

                        @foreach ($sidebar_top as $sidebar_top_item)
                        
                            <div class="Two__sidebarItem">

                                {!! $sidebar_top_item !!}
                                    
                            </div>

                        @endforeach

                    </div>

                @endif

                @foreach ($content as $content_item)
                
                <div class="Two__contentItem">

                    {!! $content_item !!}
                        
                </div>

                @endforeach

            </main>

            @if($sidebar_top->isNotEmpty() || $sidebar->isNotEmpty())

            <aside class="Two__sidebar">

                <div class="Two__sidebarTop">

                @foreach ($sidebar_top as $sidebar_top_item)
                
                    <div class="Two__sidebarItem">

                        {!! $sidebar_top_item !!}
                            
                    </div>

                @endforeach

                </div>

                <div class="Two__sidebarBottom">

                @foreach ($sidebar as $sidebar_item)
                            
                    <div class="Two__sidebarItem">

                        {!! $sidebar_item !!}
                            
                    </div>

                @endforeach

                </div>

            </aside>

            @endif

        </div>

    </div>

</div>

@if ($bottom->count())

<div class="Two__bottomOuterContainer">

    <section class="container">

        @foreach ($bottom as $bottom_item)
        
            <div class="Two__bottomItem">

                {!! $bottom_item !!}
                    
            </div>
                
        @endforeach

    </section>
    
</div>

@endif 

@endsection

@section('footer')

    <footer class="Two__footer">

    {!! $footer !!}

    </footer>

@endsection