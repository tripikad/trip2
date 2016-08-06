@php

$route = $route ?? '';
$method = $method ?? 'POST';
$fields = $fields ?? collect();

@endphp

<form action="{{ $route }}" method="POST" accept-charset="utf-8">

    <input name="_method" type="hidden" value="{{ $method }}">
    
    {{ csrf_field() }}

    @foreach ($fields->withoutLast() as $field)
    
        <div class="margin-bottom-sm">

        {!! $field !!}
        
        </div>

    @endforeach

    <div>

        {!! $fields->last() !!}
        
    </div>

</form>
