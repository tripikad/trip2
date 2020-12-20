<div {{ $attributes->merge(['class' => 'CompanyVacationPackageItem']) }}>
    <div class="CompanyVacationPackageItem__image">
        <img src="https://www.worldwideinsure.com/travel-blog/wp-content/uploads/2017/12/Hotel-Room-Image-by-Megha01-CC0.jpg"/>
    </div>
    <div class="CompanyVacationPackageItem__content">
        <div class="CompanyVacationPackageItem__content__title">
            <a href="#">{{$package->name}}</a>
        </div>
        <div class="CompanyVacationPackageItem__content__description">
            {{strip_tags($package->short_description())}}
        </div>
        <div class="CompanyVacationPackageItem__content__meta">
            <div class="CompanyVacationPackageItem__content__meta__until">Pakkumine kehtib kuni {{$package->end_date}}</div>
            <div class="CompanyVacationPackageItem__content__meta__edit-btn">
                <a href="{{route('company.edit_package', ['company' => $package->company_id, 'package' => $package])}}">Muuda</a>
            </div>
            <div class="CompanyVacationPackageItem__content__meta__edit-btn">
                <a href="#">Kopeeri</a>
            </div>
        </div>
    </div>

</div>