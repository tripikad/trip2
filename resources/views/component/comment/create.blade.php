{!! Form::open(array('url' => route('comment.store', [$content->type, $content->id]))) !!}

<div class="c-form__group">

    {!! Form::textarea('body', null, [
        'class' => 'c-form__input m-high',
        'placeholder' => trans('comment.create.field.body.title'),
        'rows' => 5
    ]) !!}

</div>

<div class="c-form__group m-no-margin m-right">

    {!! Form::submit(trans('comment.create.submit.title'), [
    'class' => 'c-button m-small'
    ]) !!}

</div>

{!! Form::close() !!}
