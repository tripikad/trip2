{{--

title: Form component with Dropzone

code: |

    @include('component.image.form', [
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

                        {!! Form::file($name, [
                            'class' => 'c-form__input m-medium dropzone-input'
                        ]) !!}

                        {!! Form::submit('Submit', [
                            'class' => 'c-button m-small'
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

        <div class="c-form__input-wrap">

            <div class="c-form__group">

                @if (in_array($field['type'], ['text', 'textarea', 'url', 'email', 'date']))

                    {!! Form::$field['type']($key, null, [
                        'class' =>
                            (isset($field['large']) && $field['large'] == true
                                ? 'c-form__input m-high'
                                : 'c-form__input')
                            .
                            (isset($field['wysiwyg']) && $field['wysiwyg'] == true
                                ? ' js-ckeditor'
                                : ''),
                        'id' => $key,
                        'placeholder' => trans("content.$type.edit.field.$key.title"),
                        'rows' => isset($field['rows']) ? $field['rows'] : 8,
                    ]) !!}

                @elseif ($field['type'] == 'file')

                    <div id="{{ isset($id) ? $id : 'dropzoneImage' }}" class="dropzone">

                        <div class="fallback">

                            <div class="form-group">

                                {!! Form::$field['type']($key) !!}

                            </div>

                        </div>

                    </div>

                @elseif ($field['type'] == 'image_id')

                    {!! Form::text($key, null, [
                        'class' => 'c-form__input',
                        'placeholder' => trans("content.$type.edit.field.$key.title"),
                    ]) !!}

                @elseif ($field['type'] == 'destinations')

                    {!! Form::select(
                        $key . '[]',
                        $destinations,
                        $destination,
                        [
                            'multiple' => 'true',
                            'id' => $key,
                            'class' => 'js-filter',
                            'placeholder' => trans("content.$type.edit.field.$key.title"),
                        ]
                    )!!}

                @elseif ($field['type'] == 'topics')

                    {!! Form::select(
                        $key . '[]',
                        $topics,
                        $topic,
                        [
                            'multiple' => 'true',
                            'id' => $key,
                            'class' => 'js-filter',
                            'placeholder' => trans("content.$type.edit.field.$key.title"),
                        ]
                    )!!}

                @elseif ($field['type'] == 'datetime')

                    <div class="c-form__label">
                        {{ trans("content.$type.edit.field.$key.title") }}
                    </div>

                    <div class="c-columns m-6-cols m-space">
                        <div class="c-columns__item">
                            @include('component.date.select', [
                                'from' => 1,
                                'to' => 31,
                                'selected' => \Carbon\Carbon::now()->day,
                                'key' => $key.'_day'
                            ])
                        </div>
                        <div class="c-columns__item">
                            @include('component.date.select', [
                                'month' => true,
                                'selected' => \Carbon\Carbon::now()->month,
                                'key' => $key.'_month'
                            ])
                        </div>
                        <div class="c-columns__item">
                            @include('component.date.select', [
                                'from' => \Carbon\Carbon::now()->year,
                                'to' => \Carbon\Carbon::parse('+5 years')->year,
                                'selected' => \Carbon\Carbon::now()->year,
                                'key' => $key.'_year'
                            ])
                        </div>
                        <div class="c-columns__item">
                            @include('component.date.select', [
                                'from' => 0,
                                'to' => 23,
                                'selected' => \Carbon\Carbon::now()->hour,
                                'key' => $key.'_hour'
                            ])
                        </div>
                        <div class="c-columns__item">
                            @include('component.date.select', [
                                'from' => 0,
                                'to' => 59,
                                'selected' => \Carbon\Carbon::now()->minute,
                                'key' => $key.'_minute'
                            ])
                        </div>
                        <div class="c-columns__item">
                            @include('component.date.select', [
                                'from' => 0,
                                'to' => 59,
                                'selected' => '00',
                                'key' => $key.'_second'
                            ])
                        </div>
                    </div>
                @elseif ($field['type'] == 'currency')

                    {!! Form::text($key, null, [
                        'class' => 'c-form__input m-narrow',
                        'placeholder' => trans("content.$type.edit.field.$key.title"),
                    ]) !!}

                    <span class="c-form__text">

                        {{ config('site.currency.symbol') }}

                    </span>

                @elseif (in_array($field['type'], ['submit', 'button']))

                    {!! Form::submit(trans("content.$mode.submit.title"), [
                        'class' => 'c-button m-large m-block',
                        'id'    => 'submit-' . (isset($id) ? $id : 'dropzoneImage')
                    ]) !!}

                @endif

                @if (trans("content.$type.edit.field.$key.help") != '' && trans("content.$type.edit.field.$key.help") != "content.$type.edit.field.$key.help")

                    {!! Form::label($key, trans("content.$type.edit.field.$key.help", ['now' =>  $now]), [
                        'class' => 'c-form__label'
                    ]) !!}

                @endif

            </div>

        </div>

    @endforeach

@endif

{!! Form::close() !!}

@section('scripts')

    @if (isset($form['files']))

        @if ($form['files'])

            <script type="text/javascript">

                Dropzone.autoDiscover = false;


                createDropzone(
                    '.dropzone',
                    // #{{ isset($id) ? $id : 'dropzoneImage' }} <- changed to .dropzone
                    '{{ $form['url'] }}',
                    '{{ isset($form['method']) && $form['method']!='put' ? $form['method'] : 'post' }}',
                    '{{ $name }}',

                    @if (isset($maxFileSize))

                        '{{ $maxFileSize }}',

                    @else

                        '',

                    @endif

                    @if (isset($uploadMultiple))

                        @if ($uploadMultiple === true)

                            'true',

                        @else

                            'false',

                        @endif

                    @else

                        '',

                    @endif

                    @if (isset($maxFiles))

                        '{{ $maxFiles }}',

                    @else

                        '',

                    @endif

                    @if (isset($fields) && ! empty($fields))

                        'false',

                    @else

                        '',

                    @endif

                    '',

                    [
                        //'{{ trans('site.dropzone.default') }}',
                        'Üleslaadimiseks lohista fail siia või <span class="dropzone-link">vajuta siia</span>',
                        '{{ trans('site.dropzone.fallback.message') }}',
                        '{{ trans('site.dropzone.fallback.text') }}',
                        '{{ trans('site.dropzone.max.files.exceeded') }}',
                        '{{ trans('site.dropzone.file.size.exceeded') }}',
                        '{{ trans('site.dropzone.file.remove') }}',
                    ],

                    '#form-{{ isset($id) ? $id : 'dropzoneImage' }}',
                    '#submit-{{ isset($id) ? $id : 'dropzoneImage' }}'
                );

            </script>

        @endif

    @endif

@stop
