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

        <div class="row-between padding-top-lg padding-bottom-md">

            <div class="col-9 padding-right-sm-mobile-none">

                @foreach ($content as $content_item)
                
                <div @if (! $loop->last) class="margin-bottom-md" @endif>

                    {!! $content_item !!}
                        
                </div>

                @endforeach

            </div>

            <div class="col-3 padding-left-sm-mobile-none">

                @foreach ($sidebar as $sidebar_item)
                
                <div @if (! $loop->last) class="margin-bottom-md" @endif>

                    {!! $sidebar_item !!}
                        
                </div>

                @endforeach

            </div>

        </div>

    </div>

    @if ($bottom->count())

    <div class="padding-top-md padding-bottom-md background-gray">

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
