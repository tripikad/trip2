@extends('layouts.one_column')

@section('title', $content->title)

@section('content.one')
        
    {!! $content->body_filtered !!}

@stop
