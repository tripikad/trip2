@php

$user_answer = $user_answer ?? '';
$answer = $answer ?? '';
$value = $value ?? '';

@endphp

@if ($user_answer == $answer)
<div class="QuizTextRow QuizTextRow--green">
@else
<div class="QuizTextRow">
@endif

    <input
        class="QuizTextRow__input"
        type="text"
        value="{{ $value }}"
        disabled
    >

</div>