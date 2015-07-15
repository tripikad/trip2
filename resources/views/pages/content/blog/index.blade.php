@extends('layouts.main')

@section('title')
    {{ trans("content.$type.index.title") }}
@stop

@section('header.right')
    @include('components.button', [ 
        'route' => route('content.create', ['type' => $type]),
        'title' => trans("content.$type.create.title")
    ])
@stop

@section('content')
    
    @include('components.filter')

    @foreach ($contents as $content)

        <div class="row">

            <div class="col-xs-2">
                
                <a href="{{ route('user.show', [$content->user]) }}">
                    @include('components.image.circle', ['image' => $content->user->imagePath()])
                </a>
          
            </div>
            
            <div class="col-xs-10">
                
                <h3>
                    <a href="{{ route('content.show', [$content->type, $content]) }}">
                        {{ $content->title }}
                    </a>
                </h3>
                
                <p>
                {!! trans("content.$type.index.row.text", [
                    'user' => view('components.user.link', ['user' => $content->user]),
                    'created_at' => $content->created_at->format('d. m Y H:i:s'),
                    'destinations' => $content->destinations->implode('name', ','),
                    'tags' => $content->topics->implode('name', ','),
                ]) !!}
                </p>

                {!! nl2br(str_limit($content->body, 500)) !!}
            
            </div>

        </div>

        <hr />
        
    @endforeach

  {!! $contents->render() !!}

@stop

