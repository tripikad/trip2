<div>
    @foreach($packages as $package)
        <x-company.vacation-package-item :package="$package"/>
    @endforeach
</div>