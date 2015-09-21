<div class="component-footer">
    <div class="menu utils-border-bottom">
        <ul class="list-inline">

            @foreach (config('menu.footer') as $key => $data)

            <li>
                <a href="{{ $data['url'] }}"
                    @if (isset($data['external']) && $data['external'])
                        target="_blank"
                    @endif
                >
                    {{ trans("menu.footer.$key") }}
                </a>
            </li>

            @endforeach

        </ul>
    </div>
    <div class="copyright">
        {{ trans('content.footer.copyright', ['current_year' =>  \Carbon\Carbon::now()->year]) }}
    </div>
</div>