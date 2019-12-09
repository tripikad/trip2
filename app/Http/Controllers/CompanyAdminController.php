<?php

namespace App\Http\Controllers;

use App\User;
use App\Offer;

class CompanyAdminController extends Controller
{
    public function index()
    {
        $companies = User::whereCompany(true)->get();

        $offers = Offer::latest()
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->take(100)
            ->get();

        return layout('Offer')
            ->with('head_robots', 'noindex')
            ->with('title', 'Offer')
            ->with('color', 'blue')
            ->with('header', region('OfferHeader'))
            ->with(
                'content',
                collect()
                    ->push(
                        component('Title')
                            ->is('large')
                            ->is('white')
                            ->with('title', trans('company.index.title'))
                    )
                    ->push(
                        component('Button')
                            ->is('orange')
                            ->is('narrow')
                            ->with('title', trans('company.index.create'))
                            ->with('route', route('company.create'))
                    )
                    ->merge(
                        $companies->map(function ($company) {
                            return component('Flex')
                                ->with('align', 'center')
                                ->with(
                                    'items',
                                    collect()
                                        ->push(
                                            component('Title')
                                                ->is('small')
                                                ->is('white')
                                                ->with('title', $company->name)
                                                ->with('route', route('company.show', $company))
                                        )
                                        ->push(
                                            component('Button')
                                                ->is('orange')
                                                ->is('small')
                                                ->is('narrow')
                                                ->with('title', trans('company.index.edit'))
                                                ->with(
                                                    'route',
                                                    route('company.edit', [
                                                        $company,
                                                        'redirect' => 'company.admin.index'
                                                    ])
                                                )
                                        )
                                );
                        })
                    )
                    ->br()
                    ->push(
                        component('Title')
                            ->is('large')
                            ->is('white')
                            ->with('title', trans('company.index.offer'))
                    )
                    ->merge(
                        $offers->map(function ($offer) {
                            return component('OfferRow')
                                ->is($offer->status == 1 ? '' : 'unpublished')
                                ->with('offer', $offer)
                                ->with('route', $offer->status == 1 ? route('offer.show', [$offer]) : '');
                        })
                    )
            )
            ->with('footer', region('FooterLight', ''))
            ->render();
    }
}
