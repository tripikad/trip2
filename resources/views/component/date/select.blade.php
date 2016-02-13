@if (isset($month))

    {!! Form::select($key, $month, [$selected], [
        'class' => 'c-form__input',
    ]) !!}

@else

    {!! Form::select($key, $from_to, [$selected], [
        'class' => 'c-form__input',
    ]) !!}

@endif
