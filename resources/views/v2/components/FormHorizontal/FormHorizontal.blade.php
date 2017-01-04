@php

$route = $route ?? '';
$method = $method ?? 'POST';
$fields = collect($fields) ?? collect();

@endphp

<form class="FormHorizontal" action="{{ $route }}" method="POST" accept-charset="utf-8">

    {{ method_field($method) }}
    
    {{ csrf_field() }}

    @foreach ($fields as $field)
    
        <div class="FormHorizontal__field">

        {!! $field !!}
        
        </div>

    @endforeach

</form>