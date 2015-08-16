<div class="component-number {{ $options or ''}}">
    <div class="content">
        <div class="number">{{ $number or '0'}}</div>
        @if (isset($text)) <div class="text">{{ $text }}</div> @endif
    </div>
</div>