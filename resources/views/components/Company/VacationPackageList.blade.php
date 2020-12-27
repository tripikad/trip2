<div class="CompanyVPList">
    <div class="CompanyVPList__block">
        <div class="CompanyVPList__block__title">
            Aktiivsed
        </div>
        @foreach($activePackages as $package)
            <div class="CompanyVPList__block__item">
                <x-company.vacation-package-item :package="$package" asdf="asdf"/>
            </div>
        @endforeach
    </div>
    <div class="CompanyVPList__block">
        <div class="CompanyVPList__block__title">
            Mustandid
        </div>
        @foreach($draftPackages as $package)
            <div class="CompanyVPList__block__item">
                <x-company.vacation-package-item :package="$package"/>
            </div>
        @endforeach
    </div>
    <div class="CompanyVPList__block CompanyVPList__block--no-border">
        <div class="CompanyVPList__block__title">
            Aegunud
        </div>
        @foreach($expiredPackages as $package)
            <div class="CompanyVPList__block__item">
                <x-company.vacation-package-item :package="$package"/>
            </div>
        @endforeach
    </div>
</div>