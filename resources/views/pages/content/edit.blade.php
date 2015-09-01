@extends('layouts.medium')

@section('title')
    {{ trans("content.$mode.title") }}
@stop

@section('content.medium')
    
    {!! Form::model(isset($content) ? $content : null, [
        'url' => $url,
        'method' => isset($method) ? $method : 'post',
        'files' => true
    ]) !!}

    @foreach ($fields as $key => $field)

        <div class="form-group">

        @if (in_array($field['type'], ['text', 'textarea', 'url', 'email']))

            {!! Form::$field['type']($key, null, [
                'class' => 'form-control input-md',
                'placeholder' => trans("content.$type.edit.field.$key.title"),
                'rows' => isset($field['rows']) ? $field['rows'] : 8,
            ]) !!}
    
        @elseif ($field['type'] == 'file')

            @include('component.image.field', [
                'image' => isset($content) ? $content->imagePath() : null
            ])

            {!! Form::$field['type']($key) !!}

        @elseif (in_array($field['type'], ['submit', 'button']))

            <div class="row">

                <div class="col-md-4 col-md-offset-8">
                
                    {!! Form::submit(trans("content.$mode.submit.title"), [
                        'class' => 'btn btn-primary btn-md btn-block'
                    ]) !!}
                    
                </div>

            </div>

        @endif

        </div>

    @endforeach

    {!! Form::close() !!}

@stop