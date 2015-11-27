@extends('layouts.main')

@section('title')

    {{ trans("content.$type.index.title") }}

@stop

@section('header')

    @include('component.header',[
        'modifiers' => 'm-alternative'
    ])

@stop

@section('content')

    <div class="r-travelmates">

        <div class="r-travelmates__masthead">

            @include('component.masthead', [
                'modifiers' => 'm-alternative',
                'image' => \App\Image::getRandom()
            ])
        </div>

        <div class="r-travelmates__wrap">

            <div class="r-travelmates__content">

                @foreach ($contents as $index => $content)

                        <a href="{{ route('content.show', ['type' => $content->type, 'id' => $content]) }}">

                            @include('component.card', [
                                'image' => $content->user->imagePreset('small_square'),
                                'title' => $content->user->name,
                                'text' => $content->title,
                                'options' => '-center'
                            ])

                        </a>


                @endforeach

                @include('component.pagination',
                    ['collection' => $contents]
                )

            </div>

            <div class="r-travelmates__sidebar">

                <div class="r-travelmates__sidebar-block">

                    <div class="r-travelmates__sidebar-block-inner">

                        @include('component.button', [
                            'route' => route('content.create', ['type' => $type]),
                            'title' => trans("content.$type.create.title")
                        ])

                    </div>
                </div>

                <div class="r-travelmates__sidebar-block">

                    <div class="r-travelmates__sidebar-block-inner">

                        @include('component.filter')

                    </div>
                </div>

            </div>

        </div>

    </div>

@stop

@section('footer')

    @include('component.footer', [
        'modifiers' => 'm-alternative',
        'image' => \App\Image::getRandom()
    ])

@stop