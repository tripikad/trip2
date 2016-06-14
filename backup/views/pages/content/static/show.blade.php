@extends('layouts.one_column')

@section('title', trans($content->title))
@stop

@section('content.one')

    <div class="
        @if (! $content->status)
            utils-unpublished
        @endif
    ">

        <div class="r-medium-wrapper__center">
            
            <div class="r-container">
            
                {!! $content->body_filtered !!}

            </div>
        
        </div>

    </div>

@stop