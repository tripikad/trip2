@extends('layouts.form.wide')

@section('title')
    {{ $title }}
@stop

@section('form')
    
    {!! Form::model(isset($content) ? $content : null, array(
        'url' => $url,
        'method' => isset($method) ? $method : 'post'
    )) !!}

    @foreach ($fields as $key => $field)

        <div class="form-group">

        @if (in_array($field['type'], ['text', 'textarea', 'url', 'email']))

            {!! Form::$field['type']($key, null, [
                'class' => 'form-control input-md',
                'placeholder' => $field['title'],
                'rows' => isset($field['rows']) ? $field['rows'] : null,
            ]) !!}
    
        @elseif (in_array($field['type'], ['submit', 'button']))

            {!! Form::submit($field['title'], [
                'class' => 'btn btn-primary btn-lg btn-block'
            ]) !!}

        @endif

        </div>

    @endforeach

    {!! Form::close() !!}

@stop