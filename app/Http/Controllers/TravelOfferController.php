<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TravelOfferController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('travel_offer.travel_package.index');
    }
}