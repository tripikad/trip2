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
            'rows' => 8
        ]) !!}
    
    </div>

    <div class="row">

        <div class="col-md-8">
        </div>

        <div class="col-md-4">
        
            {!! Form::submit('Update comment', [
                'class' => 'btn btn-primary btn-md btn-block'
            ]) !!}
            
        </div>

    </div>

    {!! Form::close() !!}

@stop