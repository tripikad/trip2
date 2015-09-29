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

        @if (in_array($field['type'], ['text', 'textarea', 'url', 'email', 'date']))

            {!! Form::$field['type']($key, null, [
                'class' =>  isset($field['large']) ? 'form-control input-lg' : 'form-control input-md',
                'placeholder' => trans("content.$type.edit.field.$key.title"),
                'rows' => isset($field['rows']) ? $field['rows'] : 8,
            ]) !!}
    
            <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

        @elseif ($field['type'] == 'file')

            @include('component.image.field', [
                'image' => isset($content)
                    ? $content->imagePreset('medium')
                    : null
            ])

            {!! Form::$field['type']($key) !!}

            <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

        @elseif ($field['type'] == 'image_id')

            {!! Form::text($key, null, [
                'class' => 'form-control input-md',
                'placeholder' => trans("content.$type.edit.field.$key.title"),
            ]) !!}

            <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

        @elseif ($field['type'] == 'destinations')

            {!! Form::select(
                $key . '[]',
                $destinations,
                $destination,
                [
                    'multiple' => 'true',
                    'id' => $key,
                    'placeholder' => trans("content.$type.edit.field.$key.title"),
                ]
            )!!}

            <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

        @elseif ($field['type'] == 'topics')

            {!! Form::select(
                $key . '[]',
                $topics,
                $topic,
                [
                    'multiple' => 'true',
                    'id' => $key,
                    'placeholder' => trans("content.$type.edit.field.$key.title"),
                ]
            )!!}

            <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

        @elseif ($field['type'] == 'datetime')

            {!! Form::text($key, null, [
                'class' => 'form-control input-md',
                'placeholder' => trans("content.$type.edit.field.$key.title"),
            ]) !!}

            <div class="help-block">

                {{ trans("content.$type.edit.field.$key.help", ['now' => $now]) }}

            </div>

        @elseif ($field['type'] == 'currency')
        
            <div class="row">
                
                <div class="col-sm-6">
            
                    <div class="input-group">

                        {!! Form::text($key, null, [
                            'class' => 'form-control input-md',
                            'placeholder' => trans("content.$type.edit.field.$key.title"),
                        ]) !!}    

                        <span class="input-group-addon">

                            {{ config('site.currency.symbol') }}
                        </span>
                    
                    </div>

                </div>

            </div>

            <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

        @elseif (in_array($field['type'], ['submit', 'button']))

            <div class="row">

                <div class="col-md-4 col-md-offset-12">
                
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