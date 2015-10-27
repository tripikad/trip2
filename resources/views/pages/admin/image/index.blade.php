@extends('layouts.one_column')

@section('title')

    {{ trans('admin.image.index.title') }}

@stop

@section('header2.content')

    @include('component.nav', [
        'menu' => 'admin',
        'items' => config('menu.admin')
    ])

@stop

@section('header1.right')

    @include('component.image.create')

@stop

@section('content.one')

    <div class="row">

        @foreach ($images as $index => $image)

            <div class="col-xs-4 col-sm-2 utils-padding-bottom utils-padding-right">

                @include('component.card', [
                    'image' => $image->preset('xsmall_square'),
                    'options' => '-noshade'
                ])

                <div class="form-group">

                {!! Form::text('id', "[[$image->id]]", [
                    'class' => 'form-control input-md',
                ]) !!}

                </div>

                {{ $image->filename }}

            </div>

            @if (($index + 1) % 6 == 0) </div><div class="row"> @endif

        @endforeach

    </div>

    {!! $images->render() !!}

@stop

