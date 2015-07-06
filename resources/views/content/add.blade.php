@extends('layout.form.wide')

@section('title')
    Add news
@stop

@section('form')

    {!! Form::open(array('url' => '/auth/register')) !!}

        <div class="form-group">
            {!! Form::text('title', null, [
                'class' => 'form-control input-lg',
                'placeholder' => 'Title'
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::url('url', null, [
                'class' => 'form-control input-md',
                'placeholder' => 'Link URL'
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::textarea('body', null, [
                'class' => 'form-control input-md',
                'rows' => 10
            ]) !!}
        </div>

        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    {!! Form::checkbox('follow') !!}
                    {!! Form::label('follow', 'Follow this topic') !!}
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::submit('Add', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
                </div>
            </div>
        </div>

    {!! Form::close() !!}

@stop