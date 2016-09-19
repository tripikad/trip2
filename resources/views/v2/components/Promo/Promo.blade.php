@php

$promo = $promo ?? '';
$id2 = config("promo.$promo.id2");

@endphp

<div id="{{ $id2 }}" class="Promo {{ $isclasses }}"></div>

@push('scripts')
    <script type="text/javascript">
        googletag.cmd.push(function() { googletag.display('{{ $id2 }}'); });
    </script>
@endpush