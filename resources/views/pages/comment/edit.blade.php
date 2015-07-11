@extends('layouts.form.wide')

@section('title')
    Edit comment
@stop

@section('form')
    
    {!! Form::model($comment, array(
        'url' => 'comment/' . $comment->id,
        'method' => 'put'
    )) !!}

    <div class="form-group">
    
        {!! Form::textarea('body', null, [
            'class' => 'form-control input-md',
            'placeholder' => 'Comment',
            'rows' => 5
        ]) !!}
    
    </div>

    <div class="form-group">
    
        {!! Form::submit('Update comment', [
            'class' => 'btn btn-primary btn-lg btn-block'
        ]) !!}
    
    </div>

    {!! Form::close() !!}

@stop