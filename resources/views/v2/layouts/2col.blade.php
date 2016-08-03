@extends('v2.layouts.main')

@section('header', $header)

@section('content')

    <div class="container">

        <div class="row-between padding-top-md padding-bottom-md">

            <div class="col-8 padding-right-collapse-sm">

                @foreach ($content->withoutLast() as $content_item)
                
                <div class="margin-bottom-md">

                    {!! $content_item !!}
                        
                </div>

                @endforeach

                <div>

                    {!! $content->last() !!}
                        
                </div>

            </div>

            <div class="col-4 padding-left-collapse-sm">

                @foreach ($sidebar->withoutLast() as $sidebar_item)
                
                <div class="margin-bottom-md">

                    {!! $sidebar_item !!}
                        
                </div>

                @endforeach

                <div>

                    {!! $sidebar->last() !!}
                        
                </div>

            </div>

        </div>

    </div>

@endsection

@section('footer', $footer)
