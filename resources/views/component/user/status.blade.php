<div class="c-user-status">

    @if(isset($status))

        @if($status == 1)

            @if(isset($editor))

                @include('component.tooltip', [
                    'modifiers' => 'm-one-line m-top m-center '. $modifiers,
                    'text' => 'Amatöör / Toimetaja'
                ])

            @else

                @include('component.tooltip', [
                    'modifiers' => 'm-one-line m-top m-center '. $modifiers,
                    'text' => 'Amatöör'
                ])

            @endif

        @elseif($status == 2)

            @if(isset($editor))

                @include('component.tooltip', [
                    'modifiers' => 'm-one-line m-top m-center '. $modifiers,
                    'text' => 'Edasijõudnud / Toimetaja'
                ])

            @else

                @include('component.tooltip', [
                    'modifiers' => 'm-one-line m-top m-center '. $modifiers,
                    'text' => 'Edasijõudnud'
                ])

            @endif

        @elseif($status == 3)

            @if(isset($editor))

                @include('component.tooltip', [
                    'modifiers' => 'm-one-line m-top m-center '. $modifiers,
                    'text' => 'Tripikas / Toimetaja'
                ])

            @else

                @include('component.tooltip', [
                    'modifiers' => 'm-one-line m-top m-center '. $modifiers,
                    'text' => 'Tripikas'
                ])

            @endif

        @else

            @if(isset($editor))

                @include('component.tooltip', [
                    'modifiers' => 'm-one-line m-top m-center '. $modifiers,
                    'text' => 'Guru / Toimetaja'
                ])

            @else

                @include('component.tooltip', [
                    'modifiers' => 'm-one-line m-top m-center '. $modifiers,
                    'text' => 'Guru'
                ])

            @endif

        @endif

    @endif

</div>