@php

$header = $header ?? '';
$content = $content ?? collect();
$bottom = $bottom ?? collect();
$footer = $footer ?? '';

@endphp

@extends('v2.layouts.main')

@section('header', $header)

@section('content')

    <div class="margin-top-negative-lg">
        
    <div class="container">

        <div class="row row-center padding-bottom-md">

            <div class="col-10">

                @foreach ($content->withoutLast() as $content_item)
                
                <div class="margin-bottom-lg">

                    {!! $content_item !!}
                        
                </div>

                @endforeach

                <div>

                    {!! $content->last() !!}
                        
                </div>

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


