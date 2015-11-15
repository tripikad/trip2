{{--

title: Image field

code: |

    @include('component.image.create', [
        'form' => [
            'url' => '',
            'method' => 'post',
            'model' => null
        ],
        'id' => 'uniqueId',
        'name' => 'image',
        'maxFileSize' => 5,
        'uploadMultiple' => true,
        'maxFiles' => 1
    ])

--}}

@if(isset($form['model']))

    {!! Form::model($form['model'], [
        'url' => $form['url'],
        'method' => isset($form['method']) ? $form['method'] : 'post',
        'files' => true,
        'class' => 'dropzone',
        'id' => isset($id) ? $id : 'dropzoneImage'
    ]) !!}

@else

    {!! Form::open([
        'url' => $form['url'],
        'method' => isset($form['method']) ? $form['method'] : 'post',
        'files' => true,
        'class' => 'dropzone',
        'id' => isset($id) ? $id : 'dropzoneImage'
    ]) !!}

@endif

{!! Form::hidden($name.'_submit', '1') !!}

<div class="fallback">

    <div class="form-group">

        {!! Form::file($name) !!}

        {!! Form::submit('Submit', [
            'class' => 'btn btn-primary'
        ]) !!}

    </div>

</div>

{!! Form::close() !!}

@section('scripts')

    <script type="text/javascript">

        Dropzone.options.{{ $id or 'dropzoneImage' }} = {
            paramName: '{{ $name }}',

            @if(isset($maxFileSize))

                maxFilesize: {{ $maxFileSize }},

            @endif

            @if(isset($uploadMultiple))

                uploadMultiple: {{ $uploadMultiple ? 'true' : 'false' }},

            @endif

            @if(isset($maxFiles))

                maxFiles: {{ $maxFiles }},

            @endif

            dictDefaultMessage: '{{ trans('site.dropzone.default') }}',
            dictFallbackMessage: '{{ trans('site.fallback.message') }}',
            dictFallbackText: '{{ trans('site.fallback.text') }}',
            dictMaxFilesExceeded: '{{ trans('site.max.files.exceeded') }}',
            dictFileTooBig: '{{ trans('site.file.size.exceeded') }}',

            @if(isset($uploadMultiple) && $uploadMultiple == true)

                init: function () {
                    this.on('successmultiple', function () {
                        location.reload();
                    });
                },

            @else

                init: function () {
                    this.on('success', function () {
                        location.reload();
                    });
                },

            @endif
        };

    </script>

@stop
