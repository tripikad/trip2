@if (isset($month))

    {!! Form::select($key, $month, [$selected]) !!}

@else

    {!! Form::selectRange($key, $from, $to, [$selected]) !!}

@endif
