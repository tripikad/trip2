@if (isset($month))

    {!! Form::select($key, $month, [$selected], [
        'class' => 'c-form__select',
    ]) !!}

@else

    {!! Form::select($key, $from_to, [$selected], [
        'class' => 'c-form__select',
    ]) !!}

@endif
