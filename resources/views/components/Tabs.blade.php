<ul {{ $attributes->merge(['class' => 'Tabs']) }}>
    @foreach($tabs as $tab)
        <x-tab
            :title="$tab['title']"
            :route="$tab['route']"
            :active="$tab['active']"
            :count="$tab['count']"/>
    @endforeach
</ul>