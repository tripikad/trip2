<div id="{{ $id }}" class="Promo"></div>

@push('scripts')
    <script type="text/javascript">
        googletag.cmd.push(function() {
            googletag.display('{{ $id }}');
        });
    </script>
@endpush