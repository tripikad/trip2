@php

$header = $header ?? '';
$content = $content ?? collect();
$bottom = $bottom ?? collect();
$footer = $footer ?? '';

@endphp

@extends('v2.layouts.main')

@section('header', $header)

@section('content')

    <div class="container">

        <div class="row row-center padding-top-md padding-bottom-md">

            <div class="col-9">

                @foreach ($content as $content_item)
                
                <div @if (! $loop->last) class="margin-bottom-md" @endif>

                    {!! $content_item !!}
                        
                </div>

                @endforeach

            </div>

        </div>

    </div>

    <div class="container">

    @foreach ($bottom as $bottom_item)
    
        <div @if (! $loop->last) class="margin-bottom-md" @endif>

            {!! $bottom_item !!}
                
        </div>
            
    @endforeach

    </div>
    
@endsection

@section('footer', $footer)


