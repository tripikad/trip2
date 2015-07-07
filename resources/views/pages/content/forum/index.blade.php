@extends('layouts.main')

@section('action.secondary')
    @include('components.placeholder', ['text' => 'Filters ▾'])
@stop

@section('action.primary')
    @include('components.placeholder', ['text' => '＋ Add new post'])
@stop

@section('title')
{{ $title }}
@stop

@section('content')

    @foreach ($contents as $content)

        @include('components.row', [
            'image' => $content->user->imagePath(),
            'image_link' => '/user/' . $content->user->id,
            'heading' => $content->title,
            'heading_link' => '/content/' . $content->id,
            'text' => 'By <a href="/user/' . $content->user->id .'">'
                . $content->user->name
                . '</a> created at '
                . $content->created_at->format('d. m Y H:i:s')
                . '</a> latest comment at '
                . $content->updated_at->format('d. m Y H:i:s')
                . ' about '
                . $content->destinations->implode('name', ',')
                . ' tagged as '
                . $content->topics->implode('name', ',')
        ])

        <hr />

        {{--

        by @include('user.item', ['user' => $content->user])
        at {{ $content->created_at->format('d.m.Y') }}
        ({{ count($content->comments) }},
        latest at {{ $content->updated_at->format('d. m Y') }})
        @include('destination.index', ['destinations' => $content->destinations])
        @include('topic.index', ['topics' => $content->topics])

        --}}

    @endforeach

  {!! $contents->render() !!}

@stop