<div class="VacationPackageList">
    <div class="VacationPackageList__block">
        <div class="VacationPackageList__title">
            Aktiivsed
        </div>
        @foreach($activePackages as $package)
            <div class="VacationPackageList__item">
                <x-vacation-package.list-item :package="$package"/>
            </div>
        @endforeach
    </div>
    <div class="VacationPackageList__block">
        <div class="VacationPackageList__title">
            Mustandid
        </div>
        @foreach($draftPackages as $package)
            <div class="VacationPackageList__item">
                <x-vacation-package.list-item :package="$package"/>
            </div>
        @endforeach
    </div>
    <div class="VacationPackageList__block VacationPackageList__block--no-border">
        <div class="VacationPackageList__title">
            Aegunud
        </div>
        @foreach($expiredPackages as $package)
            <div class="VacationPackageList__item">
                <x-vacation-package.list-item :package="$package"/>
            </div>
        @endforeach
    </div>
</div>