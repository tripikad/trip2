@extends('layout')

@section('title')
{{ $title }}
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-4" style="margin-bottom: 1.5em;">

                @include('image.landscape', ['image' => $content->imagePath()])
                {{--
                <div class="row">
                    
                    <div class="col-xs-2 col-sm-3">
                        <a href="/user/{{ $content->user->id }}">
                            @include('image.circle', ['image' => $content->user->imagePath()])
                        </a>
                    </div>

                    <div class="col-xs-10 col-sm-9">
                        {{ $content->title }}
                        <p>by @include('user.item', ['user' => $content->user])
                        at {{ $content->created_at->format('d.m.Y') }}:
                        </p>
                    </div>
            
                </div>
                --}}
            </div>


            
            @if (($index + 1) % 3 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $contents->render() !!}

@stop

