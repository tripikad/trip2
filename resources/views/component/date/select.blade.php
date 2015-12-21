@if (isset($month))

    {!! Form::select($key, $month, [$selected]) !!}

@else

    {!! Form::select($key, $from_to, [$selected]) !!}

@endif
