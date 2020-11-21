@if ($errors->count())

    <div {{ $attributes->merge(['class' => 'FormErrorSection']) }}>

        @foreach ($errors->all() as $error)

            <div class="FormErrorSection__title">

                {{ $error }}

            </div>

        @endforeach

    </div>

@endif