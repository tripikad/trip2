@php

$content = $content ?? collect();

@endphp

@extends('v2.layouts.main')

@section('content')

    @foreach ($content as $content_item)
                    
        {!! $content_item !!}
                    
    @endforeach

@endsection
