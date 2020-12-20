<?php

namespace App\View\Components\Company;

use App\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class VacationPackageList extends Component
{
    public Collection $packages;

    public function __construct(Company $company)
    {
        $this->packages = $company->vacationPackages()->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Company.VacationPackageList');
    }
}
