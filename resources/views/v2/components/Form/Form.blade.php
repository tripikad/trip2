@php

$route = $route ?? '';
$id = $id ?? '';
$method = $method ?? 'POST';
$fields = collect($fields) ?? collect();

@endphp

<form id="{{ $id }}" action="{{ $route }}" method="POST" accept-charset="utf-8">

    {{ method_field($method) }}
    
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
