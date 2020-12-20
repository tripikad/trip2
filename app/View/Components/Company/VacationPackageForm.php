<?php

namespace App\View\Components\Company;

use App\Company;
use App\VacationPackage;
use Illuminate\View\Component;
use Illuminate\View\View;

class VacationPackageForm extends Component
{
    public Company $company;
    public ?VacationPackage $package;

    public function __construct(Company $company, VacationPackage $package = null)
    {
        $this->company = $company;
        $this->package = $package;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Company.VacationPackageForm', [
            'submitRoute' => $this->package && $this->package->id
                ? route('company.update_package', ['company' => $this->company, 'package' => $this->package])
                : route('company.store_package', ['company' => $this->company])
        ]);
    }
}
