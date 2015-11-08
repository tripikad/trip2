{{--

title: Image field

code: |

    @include('component.image.create', [
        'id' => 'uniqueId',
        'name' => 'image',
        'maxFileSize' => 5,
        'uploadMultiple' => true,
        'maxFiles' => 1
    ])

--}}

{!! Form::open([
    'url' => route('admin.image.store'),
    'files' => true,
    'class' => 'dropzone',
    'id' => $id ? $id : 'dropzoneImage'
]) !!}

<div class="fallback">

    <div class="form-group">

        {!! Form::file($name) !!}

        {!! Form::submit(trans('admin.image.create.submit.title'), [
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
            dictFileTooBig: '{{ trans('site.file.size.exceeded') }}'
        };

    </script>

@stop
