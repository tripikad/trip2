@extends('layout')

@section('title')
{{ $title }}
@stop

@section('action.primary')
    @include('component.placeholder', ['text' => '＋ Add new post'])
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
                . '</a> latest comment at '
                . $content->updated_at->format('d. m Y H:i:s')
                . ' about '
                . $content->destinations->implode('name', ',')
                . ' tagged as '
                . $content->topics->implode('name', ',')
        ])

        <hr />

    @endforeach

    {!! $contents->render() !!}

@stop