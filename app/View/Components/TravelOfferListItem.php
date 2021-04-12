<?php

namespace App\View\Components;

use App\TravelOffer;
use Illuminate\View\Component;
use Illuminate\View\View;

class TravelOfferListItem extends Component
{
    public TravelOffer $offer;

    /**
     * Create a new component instance.
     *
     * @param TravelOffer $offer
     */
    public function __construct(TravelOffer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.TravelOfferListItem');
    }
}
