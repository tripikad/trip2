@extends('layouts.medium')

@section('title')
    {{ trans('comment.edit.title') }}
@stop

@section('content.medium')
    
    {!! Form::model($comment, array(
        'url' => 'comment/' . $comment->id,
        'method' => 'put'
    )) !!}

    <div class="form-group">
    
        {!! Form::textarea('body', null, [
            'class' => 'form-control input-md',
            'placeholder' => trans('comment.edit.body.title'),
            'rows' => 8
        ]) !!}
    
    </div>

    <div class="row">

        <div class="col-md-8">
        </div>

        <div class="col-md-4">
        
            {!! Form::submit(trans('comment.edit.submit.title'), [
                'class' => 'btn btn-primary btn-md btn-block'
            ]) !!}
            
        </div>

    </div>

    {!! Form::close() !!}

@stop