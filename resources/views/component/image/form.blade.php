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

            @if (trans("content.$type.edit.field.$key.title") != '' && trans("content.$type.edit.field.$key.title") != "content.$type.edit.field.$key.title")
                {!! Form::label($key, trans("content.$type.edit.field.$key.title"), [
                    'class' => 'c-form__label'
                ]) !!}
            @endif

            @if (in_array($field['type'], ['text', 'textarea', 'url', 'email', 'date']))

                {!! call_user_func('Form::'.$field['type'], $key, null, [
                    'class' =>
                        (isset($field['large']) && $field['large'] == true
                            ? 'c-form__input m-high'
                            : 'c-form__input')
                        .
                        (isset($field['wysiwyg']) && $field['wysiwyg'] == true
                            ? ' js-ckeditor'
                            : ''),
                    'id' => $key,
                    'placeholder' => (trans("content.$type.edit.field.$key.help") == '' || trans("content.$type.edit.field.$key.help") == "content.$type.edit.field.$key.help" ? trans("content.$type.edit.field.$key.title") : trans("content.$type.edit.field.$key.help", ['now' =>  $now])),
                    'rows' => isset($field['rows']) ? $field['rows'] : 8,
                ]) !!}

            @elseif ($field['type'] == 'file')

                <div id="{{ isset($id) ? $id : 'dropzoneImage' }}" class="dropzone">
                    <div class="fallback">
                        <div class="form-group">
                            {!! call_user_func('Form::'.$field['type'], $key) !!}
                        </div>
                    </div>
                </div>

            @elseif ($field['type'] == 'radio')

                <div class="c-columns m-2-cols m-border">

                    @foreach(config($field['items']) as $index => $item)
                        <div class="c-columns__item">
                            <div class="c-form__group-radio js-radio-wrap">
                                {{ Form::radio('type', $item['type'], null, [
                                    'class' => 'c-form__input m-radio js-radio',
                                    'id' => $item['type']
                                ]) }}
                                {!! Form::label($item['type'], trans($item['title']),[
                                    'class' => 'c-form__label m-radio js-radio'
                                ]) !!}
                            </div>
                        </div>

                        @if (($index + 1) % 2 == 0)
                            <div class="c-columns m-2-cols m-border">
                            </div>
                        @endif
                    @endforeach

                </div>

            @elseif ($field['type'] == 'image_id')

                {!! Form::text($key, null, [
                    'class' => 'c-form__input',
                    'placeholder' => (trans("content.$type.edit.field.$key.help") == '' || trans("content.$type.edit.field.$key.help") == "content.$type.edit.field.$key.help" ? trans("content.$type.edit.field.$key.title") : trans("content.$type.edit.field.$key.help", ['now' =>  $now]))
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
                        'placeholder' => (trans("content.$type.edit.field.$key.help") == '' || trans("content.$type.edit.field.$key.help") == "content.$type.edit.field.$key.help" ? trans("content.$type.edit.field.$key.title") : trans("content.$type.edit.field.$key.help", ['now' =>  $now]))
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
                        'placeholder' => (trans("content.$type.edit.field.$key.help") == '' || trans("content.$type.edit.field.$key.help") == "content.$type.edit.field.$key.help" ? trans("content.$type.edit.field.$key.title") : trans("content.$type.edit.field.$key.help", ['now' =>  $now]))
                    ]
                )!!}

            @elseif ($field['type'] == 'datetime')
                @php
                    if (isset($form['model']) && $form['model']) {
                        $dateTime = \Carbon\Carbon::parse($form['model'][$key]);
                    } else {
                        $dateTime = \Carbon\Carbon::now();
                    }
                @endphp

                <div class="c-columns m-3-cols m-space">
                    <div class="c-columns__item">
                        @include('component.date.select', [
                            'from' => 1,
                            'to' => 31,
                            'selected' => $dateTime->day,
                            'key' => $key.'_day'
                        ])
                    </div>
                    <div class="c-columns__item">
                        @include('component.date.select', [
                            'month' => true,
                            'selected' => $dateTime->month,
                            'key' => $key.'_month'
                        ])
                    </div>
                    <div class="c-columns__item">
                        @include('component.date.select', [
                            'from' => \Carbon\Carbon::now()->year,
                            'to' => \Carbon\Carbon::parse('+5 years')->year,
                            'selected' => $dateTime->year,
                            'key' => $key.'_year'
                        ])
                    </div>
                </div>
            @elseif ($field['type'] == 'currency')

                {!! Form::text($key, null, [
                    'class' => 'c-form__input m-narrow',
                    'placeholder' => (trans("content.$type.edit.field.$key.help") == '' || trans("content.$type.edit.field.$key.help") == "content.$type.edit.field.$key.help" ? trans("content.$type.edit.field.$key.title") : trans("content.$type.edit.field.$key.help", ['now' =>  $now]))
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
            </div>
        </div>
    @endforeach

@endif

@if (isset($form['files']))
    {!! Form::close() !!}
@endif

@section('scripts')

    @if (isset($form['files']))

        @if ($form['files'])

            <script type="text/javascript">

                Dropzone.autoDiscover = false;


                createDropzone(
                    '.dropzone',
                    /* #{{ isset($id) ? $id : 'dropzoneImage' }} <- changed to .dropzone */
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
                        '{!! trans('site.dropzone.default') !!}',
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
