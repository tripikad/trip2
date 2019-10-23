@php

$route = $route ?? '';
$id = $id ?? '';
$method = $method ?? 'POST';
$fields = $fields ?? [];
$files = $files ?? false;

@endphp

<form
    id="{{ $id }}"
    action="{{ $route }}"
    method="POST"
    accept-charset="utf-8"
    @if ($files) enctype="multipart/form-data" @endif
>

    {{ method_field($method) }}
    
    {{ csrf_field() }}

    @foreach ($fields as $field)
    
        <div class="Form__field">

        {!! $field !!}
        
        </div>

    @endforeach

</form>
