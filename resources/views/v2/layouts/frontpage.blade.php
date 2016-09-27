@php

$header = $header ?? '';
$content = $content ?? collect();
$bottom = $bottom ?? collect();
$footer = $footer ?? '';

@endphp

@extends('v2.layouts.main')

@section('header', $header)

@section('content')

    <div class="margin-top-negative-md">
        
        <div class="container">

            <div class="row row-center padding-bottom-md">

                <div class="col-10">

                    @foreach ($content as $content_item)
                    
                    <div @if (!$loop->last) class="margin-bottom-xl" @endif>

                        {!! $content_item !!}
                            
                    </div>

                    @endforeach

                </div>

            </div>

        </div>

        <div class="background-gray padding-top-lg padding-bottom-lg">

            <div class="container">

                <div class="row row-center">

                    <div class="col-10">

                    @foreach ($bottom as $bottom_item)
                    
                        <div @if (!$loop->last) class="margin-bottom-lg" @endif>

                            {!! $bottom_item !!}
                                
                        </div>
                            
                    @endforeach

                    </div>

                </div>

            </div>

        </div>
    
    </div>
    
@endsection

@section('footer', $footer)


