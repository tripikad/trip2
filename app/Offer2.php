<?php

namespace App;

class Offer2
{
    protected $id;
    protected $offers;

    public function __construct()
    {
        $sheet_id = '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE';
        $this->offers = google_sheet($sheet_id);
    }

    public function get()
    {
        return $this->offers;
    }

    public function find($id)
    {
        $offer = (object) $this->offers[$id];
        $offer->id = $id;

        return $offer;
    }
}
