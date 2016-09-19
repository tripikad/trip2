@php

$promo = $promo ?? '';
$config = config("promo.$promo");
$ratio = round(($config['height'] / $config['width']) * 100);
$id2 = $config['id2'];

@endphp

<div id="{{ $id2 }}" class="Promo {{ $isclasses }}" style="padding-bottom: {{ $ratio }}%;"></div>

@push('scripts')
    <script type="text/javascript">
        googletag.cmd.push(function() { googletag.display('{{ $id2 }}'); });
    </script>
@endpush