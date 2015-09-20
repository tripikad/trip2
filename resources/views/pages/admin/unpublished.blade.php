@extends('layouts.main')

@section('title')
    {{ trans("admin.unpublished.title") }}
@stop

@section('navbar.bottom')

    <div class="utils-border-bottom">
            
        @include('component.menu', [
            'menu' => 'admin',
            'items' => config('menu.admin')
        ])
        
    </div>

@stop

@section('content')
    
    @foreach ($contents as $content)

        <div class="utils-border-bottom utils-unpublished">

        @include('component.row', [
            'image' => $content->user->imagePreset(),
            'image_link' => route('user.show', [$content->user]),
            'heading' => $content->title,
            'heading_link' => route('content.show', [$content->type, $content->id]),
            'text' => trans("admin.unpublished.row.text", [
                'type' => $content->type,
                'created_at' => view('component.date.relative', ['date' => $content->created_at]),
            ]),
        ])
        
        </div>

    @endforeach

  {!! $contents->render() !!}

@stop