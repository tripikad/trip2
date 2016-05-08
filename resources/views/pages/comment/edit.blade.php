@extends('layouts.one_column')

@section('title', trans('comment.edit.title'))

@section('content.one')
    
    {!! Form::model($comment, array(
        'url' => 'comment/' . $comment->id,
        'method' => 'put'
    )) !!}

    <div class="c-form__group">
    
        {!! Form::textarea('body', null, [
            'class' => 'c-form__input m-high',
            'placeholder' => trans('comment.edit.body.title'),
            'rows' => 8
        ]) !!}
    
    </div>

    <div class="c-form__group m-no-margin m-right">

        {!! Form::submit(trans('comment.edit.submit.title'), [
            'class' => 'c-button m-small'
        ]) !!}
            
    </div>

    {!! Form::close() !!}

@stop