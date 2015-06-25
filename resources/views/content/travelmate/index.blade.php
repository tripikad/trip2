@extends('layout')

@section('title')
{{ $title }}
@stop

@section('content')

    <div class="row">
  
        @foreach ($contents as $index => $content)

            <div class="col-sm-3">

                @include('user.image', ['user' => $content->user])
                
                <h4><a href="/content/{{ $content->id }}">{{ $content->title }}</a></h4>
                            
            </div>

            @if (($index + 1) % 4 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

  {!! $contents->render() !!}

@stop

