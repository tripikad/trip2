@php

$route = $route ?? '';
$method = $method ?? 'POST';
$fields = collect($fields) ?? collect();
$files = $files ?? false;

@endphp

<form
    class="FormHorizontal"
    action="{{ $route }}"
    method="POST"
    accept-charset="utf-8"
    @if ($files) enctype="multipart/form-data" @endif
>

    {{ method_field($method) }}
    
    {{ csrf_field() }}

    @foreach ($fields as $field)
    
        <div class="FormHorizontal__field">

        {!! $field !!}
        
        </div>

    @endforeach

</form>