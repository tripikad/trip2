@php

$options = $options ?? collect();
$answer = $answer ?? collect();
$user_answer = $user_answer ?? colelct();

@endphp

<div class="QuizOptionRow">

    @foreach($options as $option)

    <div 
        @if (in_array($option, $answer))
            class="margin-bottom-md QuizOptionRow--green"
        @elseif (in_array($option, $user_answer))
            class="margin-bottom-md QuizOptionRow--red"
        @else
            class="margin-bottom-md"
        @endif
    >

        <input
            id="{{ $option }}"
            name="{{ $option }}"
            type="{{ $type }}"
            @if (in_array($option, $user_answer)) checked @endif
            disabled
            class="QuizOptionRow__checkbox" 
        >

        <label for="{{ $option }}" class="QuizOptionRow__label">{{ $option }}</label>

    </div>

    @endforeach

</div>