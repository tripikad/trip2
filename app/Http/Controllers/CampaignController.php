<?php

namespace App\Http\Controllers;

class CampaignController extends Controller
{
    public function index()
    {
        return \View::make('pages.campaign.index')
            ->render();
    }
}
