@php

$header = $header ?? '';
$content = $content ?? collect();
$content_mid_left = $content_mid_left ?? collect();
$content_mid_right = $content_mid_right ?? collect();
$content2 = $content2 ?? collect();
$bottom = $bottom ?? collect();
$footer = $footer ?? '';

@endphp

@extends('v2.layouts.main')

@section('header', $header)

@section('content')

    <div class="margin-top-negative-md">
        
    <div class="container">

        <div class="row row-center padding-bottom-md">

            <div class="col-12">

                @foreach ($content as $content_item)
                
                <div class="margin-bottom-md">

                    {!! $content_item !!}
                        
                </div>

                @endforeach

                <div class="row row-between">

                    <div class="col-9">

                        @foreach ($content_mid_left as $content_mid_left_item)
                        
                        <div class="margin-bottom-md">

                            {!! $content_mid_left_item !!}
                                
                        </div>

                        @endforeach

                    </div>

                    <div class="col-3">

                        @foreach ($content_mid_right as $content_mid_right_item)
                        
                        <div class="margin-bottom-md">

                            {!! $content_mid_right_item !!}
                                
                        </div>

                        @endforeach

                    </div>

                </div>

                @foreach ($content2 as $content_item)
                
                <div class="margin-bottom-lg">

                    {!! $content_item !!}
                        
                </div>

                @endforeach

            </div>

        </div>

    </div>

    <div class="container">

    @foreach ($bottom as $bottom_item)
    
        <div class="margin-bottom-md">

            {!! $bottom_item !!}
                
        </div>
            
    @endforeach

    </div>
    
    </div>
    
@endsection

@section('footer', $footer)