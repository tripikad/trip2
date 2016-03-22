@extends('layouts.one_column')

@section('title')

    {{ trans('admin.image.index.title') }}

@stop

@section('header2.content')

    @include('component.nav', [
        'modifiers' => '',
        'menu' => 'admin',
        'items' => config('menu.admin')
    ])

@stop

@section('content.one')

    <div class="c-form__group">

        @include('component.image.form', [
            'form' => [
                'url' => route('admin.image.store'),
                'files' => true
            ],
            'name' => 'image',
            'maxFileSize' => 5,
            'uploadMultiple' => false
        ])

    </div>

    <div class="c-columns m-4-cols m-space">

        @foreach ($images as $index => $image)

            <div class="c-columns__item">

                @include('component.card', [
                    'image' => $image->preset('small'),
                    'text' => $image->filename,
                    'modifiers' => 'm-wrap-text'
                ])

                <div class="form-group">

                {!! Form::text('id', "[[$image->id]]", [
                    'class' => 'c-form__input js-autoselect',
                ]) !!}

                </div>

            </div>

            @if (($index + 1) % 4 == 0)

                </div>

                <div class="c-columns m-4-cols m-space">

            @endif

        @endforeach

    </div>

    @include('component.pagination',
        ['collection' => $images]
    )

@stop
