<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;
use App\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        $continents = collect([
            'Põhja-Ameerika',
            'Euroopa',
            'Aasia',
            'Kesk-Ameerika',
            'Lähis-Ida',
            'Austraalia ja Okeaania',
            'Lõuna-Ameerika',
            'Aafrika',
            'Antarktika'
        ])->map(function ($name) {
            return Destination::continents()
                ->whereName($name)
                ->first();
        });

        $areas = Destination::countries()->pluck('id');

        $dots = Destination::citiesOrPlaces()
            ->get()
            ->map(function ($d) {
                return $d->vars()->snappedCoordinates();
            })
            ->filter()
            ->values();

        return layout('Full')
            ->withHeadRobots('noindex')
            ->withTransparency(true)
            ->withTitle(trans('offer.index'))
            ->withItems(
                collect()
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withTag('header')
                            ->withBackground('yellow')
                            ->withItems(collect()->push(region('NavbarLight')))
                    )
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withBackground('yellow')
                            ->withWidth(styles('tablet-width'))
                            ->withItems(
                                collect()
                                    ->push(
                                        component('Title')
                                            ->is('white')
                                            ->is('large')
                                            ->is('center')
                                            ->with('title', 'Sihtkohad')
                                    )
                                    ->spacer()
                                    ->push(
                                        component('Dotmap')
                                            ->is('center')
                                            ->with('areas', $areas)
                                            ->with('smalldots', $dots)
                                    )
                                    ->push(
                                        component('Grid')
                                            ->with('cols', 3)
                                            ->with('gap', 3)
                                            ->with('widths', '5fr 3fr 3fr')
                                            ->with(
                                                'items',
                                                $continents->map(function ($d) {
                                                    return component('Title')
                                                        ->is('white')
                                                        ->with('title', str_replace('ja Okeaania', '', $d->name))
                                                        ->with('route', route('destination.showSlug', [$d->slug]));
                                                })
                                            )
                                    )
                            )
                    )
                    ->push(
                        component('Section')
                            ->withTag('footer')
                            ->withBackground('yellow')
                            ->withItems(collect()->push(region('FooterLight', '')))
                    )
            )
            ->render();
    }

    public function show($id)
    {
        $destination = Destination::findOrFail($id);

        return redirect(route('destination.showSlug', $destination->slug), 301);
    }

    public function showSlug($slug)
    {
        $destination = Destination::findBySlugOrFail($slug);

        $photos = Content::getLatestPagedItems('photo', 9, $destination->id);
        $forums = Content::getLatestPagedItems('forum', 8, $destination->id);

        $flights = Content::getLatestPagedItems('flight', 6, $destination->id);
        $travelmates = Content::getLatestPagedItems('travelmate', 6, $destination->id);
        $news = Content::getLatestPagedItems('news', 2, $destination->id);

        $loggedUser = request()->user();

        return layout('Two')
            ->with(
                'head_description',
                trans('site.description.destination', [
                    'name' => $destination->vars()->name
                ])
            )

            ->with('title', $destination->vars()->name)

            ->with('color', 'yellow')

            ->with('header', region('DestinationHeader', $destination, $loggedUser))

            ->with('top', collect()->pushWhen($photos->count(), region('PhotoSection', $photos, $loggedUser)))

            ->with(
                'content',
                collect()
                    ->push(
                        component('Block')
                            ->with('title', trans('destination.show.forum.title'))
                            ->with(
                                'route',
                                route('forum.index', [
                                    'destination' => $destination
                                ])
                            )
                            ->with(
                                'content',
                                $forums->map(function ($forum) {
                                    return region('ForumRow', $forum);
                                })
                            )
                    )
                    ->push(component('Promo')->with('promo', 'body'))
            )

            ->with(
                'sidebar',
                collect()
                    ->push(component('Promo')->with('promo', 'sidebar_small'))
                    ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with(
                'bottom',
                collect()
                    ->push(region('DestinationBottom', $flights, $travelmates, $news, $destination))
                    ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function edit($id)
    {
        $destination = Destination::findOrFail($id);

        return layout('Two')
            ->with(
                'header',
                region(
                    'Header',
                    collect()->push(
                        component('Title')
                            ->is('white')
                            ->is('large')
                            ->with('title', $destination->name)
                            ->with('route', route('destination.show', $destination->id))
                    )
                )
            )

            ->with(
                'content',
                collect()
                    ->push(component('Title')->with('title', trans('content.destionation.edit.title')))
                    ->push(
                        component('FormComponent')
                            ->with('route', route('destination.update', [$destination]))
                            ->with(
                                'fields',
                                collect()
                                    ->push(
                                        component('FormEditor')
                                            ->with('title', trans('content.destination.edit.description'))
                                            ->with('name', 'description')
                                            ->with('value', [old('description', $destination->description)])
                                            ->with('rows', 10)
                                    )
                                    ->push(
                                        component('FormTextfield')
                                            ->with('title', trans('content.destination.edit.user'))
                                            ->with('name', 'user')
                                            ->with('value', $destination->user ? $destination->user->name : '')
                                    )
                                    ->push(component('FormButton')->with('title', trans('content.edit.submit.title')))
                            )
                    )
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'user' => 'exists:users,name'
        ];

        $this->validate($request, $rules);

        $destination = Destination::findOrFail($id);

        $destination->description = $request->description;

        if ($request->user && $request->user != '') {
            $user = User::where('name', $request->user)->first();
            $destination->user_id = $user->id;
        }

        $destination->save();

        return redirect(route('destination.show', $destination));
    }
}
