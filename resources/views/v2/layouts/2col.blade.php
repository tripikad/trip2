@php

$header = $header ?? '';
$content = $content ?? collect();
$sidebar = $sidebar ?? collect();
$bottom = $bottom ?? collect();
$footer = $footer ?? '';

@endphp

@extends('v2.layouts.main')

@section('header', $header)

@section('content')

    <div class="container">

        <div class="row-between padding-top-xl-mobile-md padding-bottom-md">

            <div class="col-9 padding-right-md-mobile-none">

                @foreach ($content as $content_item)
                
                <div @if (! $loop->last) class="margin-bottom-md" @endif>

                    {!! $content_item !!}
                        
                </div>

                @endforeach

            </div>

            <div class="col-3 padding-left-md-mobile-none padding-top-none-mobile-md">

                @foreach ($sidebar as $sidebar_item)
                
                <div @if (! $loop->last) class="margin-bottom-md" @endif>

                    {!! $sidebar_item !!}
                        
                </div>

                @endforeach

            </div>

        </div>

    </div>

    @if ($bottom->count())

    <div class="padding-top-lg padding-bottom-lg background-gray">

        <div class="container">

        @foreach ($bottom as $bottom_item)
        
            <div @if (! $loop->last) class="margin-bottom-md" @endif>

                {!! $bottom_item !!}
                    
            </div>
                
        @endforeach

        </div>

    </div>

    @endif

@endsection

@section('footer', $footer)
