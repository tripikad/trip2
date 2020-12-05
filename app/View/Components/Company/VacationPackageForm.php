<?php

namespace App\View\Components\Company;

use App\Company;
use Illuminate\View\Component;
use Illuminate\View\View;

class VacationPackageForm extends Component
{
    public Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Company.VacationPackageForm');
    }
}
