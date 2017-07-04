{!! Form::open([
    'url' => route('content.filter', [$type]),
]) !!}

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

    <div class="c-form__group m-right @if ($destination) m-small-margin @else m-no-margin @endif">

        <a
            href="{{ route('content.index', [$type]) }}"
            class="c-link"
        >

        {{ trans('content.index.filter.reset.title') }}

        </a>

    </div>

{!! Form::close() !!}

@if ($destination)
    <div class="c-form__group m-no-margin">
        <h3>
            {!! trans('content.index.filter.destination.title', [
                'destination' =>
                    '<a href="' . route('destination.showSlug', [$destination->slug]) . '">'
                    . $destinations[$destination]
                    . '</a>'
            ]) !!}
        </h3>
    </div>
@endif
