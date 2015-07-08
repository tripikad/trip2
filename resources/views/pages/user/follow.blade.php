@extends('layouts.main')

@section('title')
    {{ $user->name }} follows
@stop

@section('content')

@if (count($user->follows))

@foreach ($user->follows as $follow)
  
    <hr />

    @include('components.row', [
        'image' => $follow->followable->user->imagePath(),
        'image_link' => '/user/' . $follow->followable->user->id,
        'heading' => $follow->followable->title,
        'heading_link' => '/content/' . $follow->followable->id,
        'text' => 'By <a href="/user/' . $follow->followable->user->id .'">'
            . $follow->followable->user->name
            . '</a> at '
            . $follow->followable->created_at->format('d. m Y H:i:s'),
    ])

@endforeach

@endif

@stop