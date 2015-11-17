{{--

title: Form component with Dropzone

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

@if (isset($form['files']))

    @if ($form['files'])

        {!! Form::model(isset($form['model']) ? $form['model'] : null, [
            'url' => $form['url'],
            'method' => isset($form['method']) ? $form['method'] : 'post',
            'files' => true,
            'id' => isset($id) ? 'form-'.$id : 'form-dropzoneImage'
        ]) !!}

        @if (! isset($fields) || empty($fields))

            <div id="{{ isset($id) ? $id : 'dropzoneImage' }}" class="dropzone">

                <div class="fallback">

                    <div class="form-group">

                        {!! Form::file($name) !!}

                        {!! Form::submit('Submit', [
                            'class' => 'btn btn-primary'
                        ]) !!}

                    </div>

                </div>

                {!! Form::hidden($name.'_submit', '1') !!}

            </div>

        @endif

    @else

        {!! Form::model(isset($form['model']) ? $form['model'] : null, [
            'url' => $form['url'],
            'method' => isset($form['method']) ? $form['method'] : 'post'
        ]) !!}

    @endif

@endif

@if (isset($fields) && ! empty($fields))

    @foreach ($fields as $key => $field)

        <div class="form-group">

            @if (in_array($field['type'], ['text', 'textarea', 'url', 'email', 'date']))

                {!! Form::$field['type']($key, null, [
                    'class' =>  isset($field['large']) ? 'form-control input-lg' : 'form-control input-md',
                    'placeholder' => trans("content.$type.edit.field.$key.title"),
                    'rows' => isset($field['rows']) ? $field['rows'] : 8,
                ]) !!}

                <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

            @elseif ($field['type'] == 'file')

                <div id="{{ isset($id) ? $id : 'dropzoneImage' }}" class="dropzone">

                    <div class="fallback">

                        <div class="form-group">

                            {!! Form::$field['type']($key) !!}

                        </div>

                    </div>

                </div>

                <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

            @elseif ($field['type'] == 'image_id')

                {!! Form::text($key, null, [
                    'class' => 'form-control input-md',
                    'placeholder' => trans("content.$type.edit.field.$key.title"),
                ]) !!}

                <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

            @elseif ($field['type'] == 'destinations')

                {!! Form::select(
                    $key . '[]',
                    $destinations,
                    $destination,
                    [
                        'multiple' => 'true',
                        'id' => $key,
                        'placeholder' => trans("content.$type.edit.field.$key.title"),
                    ]
                )!!}

                <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

            @elseif ($field['type'] == 'topics')

                {!! Form::select(
                    $key . '[]',
                    $topics,
                    $topic,
                    [
                        'multiple' => 'true',
                        'id' => $key,
                        'placeholder' => trans("content.$type.edit.field.$key.title"),
                    ]
                )!!}

                <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

            @elseif ($field['type'] == 'datetime')

                {!! Form::text($key, null, [
                    'class' => 'form-control input-md',
                    'placeholder' => trans("content.$type.edit.field.$key.title"),
                ]) !!}

                <div class="help-block">

                    {{ trans("content.$type.edit.field.$key.help", ['now' => $now]) }}

                </div>

            @elseif ($field['type'] == 'currency')

                <div class="row">

                    <div class="col-sm-6">

                        <div class="input-group">

                            {!! Form::text($key, null, [
                                'class' => 'form-control input-md',
                                'placeholder' => trans("content.$type.edit.field.$key.title"),
                            ]) !!}

                            <span class="input-group-addon">

                                {{ config('site.currency.symbol') }}
                            </span>

                        </div>

                    </div>

                </div>

                <div class="help-block">{{ trans("content.$type.edit.field.$key.help") }}</div>

            @elseif (in_array($field['type'], ['submit', 'button']))

                <div class="row">

                    <div class="col-md-4 col-md-offset-12">

                        {!! Form::submit(trans("content.$mode.submit.title"), [
                            'class' => 'btn btn-primary btn-md btn-block',
                            'id'    => 'submit-' . (isset($id) ? $id : 'dropzoneImage')
                        ]) !!}

                    </div>

                </div>

            @endif

        </div>

    @endforeach

@endif

{!! Form::close() !!}

@if (isset($form['files']))

    @if ($form['files'])

        @section('scripts')

            <script type="text/javascript">

                Dropzone.autoDiscover = false;

                $('#{{ isset($id) ? $id : 'dropzoneImage' }}').dropzone({
                    url: '{{ $form['url'] }}',
                    method:  '{{ isset($form['method']) && $form['method']!='put' ? $form['method'] : 'post' }}',
                    paramName: '{{ $name }}',

                    @if (isset($maxFileSize))

                        maxFilesize: {{ $maxFileSize }},

                    @endif

                    @if (isset($uploadMultiple))

                        uploadMultiple: {{ $uploadMultiple ? 'true' : 'false' }},

                    @endif

                    @if (isset($maxFiles))

                        maxFiles: {{ $maxFiles }},

                    @endif

                    @if (isset($fields) && ! empty($fields))

                        autoProcessQueue: false,
                        addRemoveLinks: true,

                    @endif

                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },

                    dictDefaultMessage: '{{ trans('site.dropzone.default') }}',
                    dictFallbackMessage: '{{ trans('site.dropzone.fallback.message') }}',
                    dictFallbackText: '{{ trans('site.dropzone.fallback.text') }}',
                    dictMaxFilesExceeded: '{{ trans('site.dropzone.max.files.exceeded') }}',
                    dictFileTooBig: '{{ trans('site.dropzone.file.size.exceeded') }}',
                    dictRemoveFile: '{{ trans('site.dropzone.file.remove') }}',

                    sending: function(file, xhr, formData) {

                        $('input, textarea, select', '#form-{{ isset($id) ? $id : 'dropzoneImage' }}').each(function() {

                            formData.append($(this).attr('name'), $(this).val());

                        });

                    },

                    @if (!isset($fields) || empty($fields))

                        @if (isset($uploadMultiple) && $uploadMultiple == true)

                            successmultiple: function () {
                                location.reload();
                            },

                        @else

                            success: function () {
                                location.reload();
                            },

                        @endif

                    @else

                        init: function() {
                            var myDropzone = this;

                            $("#submit-{{ isset($id) ? $id : 'dropzoneImage'}}").click(function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                myDropzone.processQueue();
                                //$('#form-{{ isset($id) ? $id : 'dropzoneImage' }}').submit();
                            });
                        },

                    @endif
            });

            </script>

        @stop

    @endif

@endif
