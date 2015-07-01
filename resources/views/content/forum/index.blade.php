@extends('layout')

@section('title')
{{ $title }}
@stop

@section('content')

  
    @foreach ($contents as $content)

        @include('component.row', [
            'image' => $content->user->imagePath(),
            'image_link' => '/user/' . $content->user->id,
            'heading' => $content->title,
            'heading_link' => '/content/' . $content->id,
            'text' => 'By <a href="/user/' . $content->user->id .'">'
                . $content->user->name
                . '</a> created at '
                . $content->created_at->format('d. m Y H:i:s')
                . '</a> updated at '
                . $content->updated_at->format('d. m Y H:i:s')
                . ' about '
                . $content->destinations->implode('name', ',')
                . ' tagged as '
                . $content->topics->implode('name', ',')
        ])

        <hr />

        {{--
        <div class="row">

            <div class="col-sm-1">
                
                <a href="/user/{{ $content->user->id }}">
                    @include('image.circle', ['image' => $content->user->imagePath()])
                </a>

            </div>
            
            <div class="col-sm-11">
                
                <h4><a href="/content/{{ $content->id }}">{{ $content->title }}</a></h4>
                
                by @include('user.item', ['user' => $content->user])
                at {{ $content->created_at->format('d.m.Y') }}
                ({{ count($content->comments) }},
                latest at {{ $content->updated_at->format('d. m Y') }})
                @include('destination.index', ['destinations' => $content->destinations])
                @include('topic.index', ['topics' => $content->topics])
            
            </div>

        </div>
    --}}
    @endforeach

  {!! $contents->render() !!}

@stop

