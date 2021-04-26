<?php

namespace App\View\Components;

use App\Services\TravelPackageService;
use App\TravelOffer;
use Illuminate\View\Component;
use Illuminate\View\View;

class TravelOfferCard extends Component
{
    public TravelOffer $offer;
    public string $backgroundImage;

    /**
     * Create a new component instance.
     *
     * @param TravelOffer $offer
     * @param TravelPackageService $service
     */
    public function __construct(TravelOffer $offer, TravelPackageService $service)
    {
        $this->offer = $offer;
        $this->backgroundImage = $service->getBackgroundImageByDestination($offer->endDestination->parent);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.TravelOfferCard');
    }
}
