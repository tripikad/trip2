<?php

namespace App\View\Components;

use App\Company;
use App\TravelOffer;
use Illuminate\View\Component;
use Illuminate\View\View;

class CompanyTravelOfferList extends Component
{
    public Company $company;
    public $travelOffers;
    public $paginator;

    /**
     * Create a new component instance.
     *
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
        $query = TravelOffer::where('travel_offers.type', 'package')
            ->where('company_id', $company->id)
            ->with('views')
            ->select('travel_offers.*', 'd2.id as parentDestinationId', 'd2.name as parentDestinationName')
            ->join('destinations as d1', 'travel_offers.end_destination_id', '=', 'd1.id')
            ->join('destinations as d2', 'd1.parent_id', '=', 'd2.id')
            ->orderBy('travel_offers.start_date', 'ASC', 'parentDestinationName', 'ASC');

        $travelOffers = $query->paginate(10);
        $paginator = $travelOffers->links('components.PaginatorExtended.PaginatorExtended');
        $this->travelOffers = $travelOffers;
        $this->paginator = $paginator;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.CompanyTravelOfferList');
    }
}
