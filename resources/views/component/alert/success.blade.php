@if (session('info'))
    <div class="c-alert m-success m-fixed js-alert">
        <div class="c-alert__inner">
            {{ session('info') }}
            <span class="c-alert__close js-alert__close">&times;</span>
        </div>
    </div>
@endif

@if (Request::path() == '/' || Request::path() == 'login')

@section('scripts')
    @parent

    <script type="text/javascript">
        $(document).ready(function() {
            var $alert = $('.c-alert');
            if ($alert.length) {
                $alert.delay(900).slideUp('slow', function(){
                    $(this).remove();
                });
            }
        });
    </script>
@stop

@endif
