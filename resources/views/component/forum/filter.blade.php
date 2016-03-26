{!! Form::open([
    'url' => route('content.filter', [$type]),
]) !!}

<div class="r-block__header">

    <div class="r-block__header-title">

        @include('component.title', [
            'title' => trans('content.index.filter.title'),
            'modifiers' => 'm-large m-green'
        ])

    </div>

    <div class="c-body">
        <p>{{ trans('content.forum.filter.text') }}</p>
    </div>
</div>

<div class="r-block__body">

    <div class="c-form__group m-small-margin">
        {!! Form::select(
            'destination',
            ['' => trans('content.index.filter.field.destination.title')]
                 + $destinations->toArray(),
            $destination,
            [
                'class' => 'js-filter'
            ]
        )!!}
    </div>

    <div class="c-form__group m-small-margin">
        {!! Form::select(
            'topic',
            ['' => trans('content.index.filter.field.topic.title')]
                 + $topics->toArray(),
            $topic,
            [
                'class' => 'js-filter'
            ]
        )!!}
    </div>

    <div class="c-form__group m-small-margin">

        {!! Form::submit(
                trans('content.index.filter.submit.title'),
                ['class' => 'c-button m-block'])
        !!}
        </div>

     <div class="c-form__group m-right m-no-margin">
        <a href="{{ route('content.index', [$type]) }}" class="c-link">

            {{ trans('content.index.filter.reset.title') }}

        </a>
    </div>

</div>

{!! Form::close() !!}
