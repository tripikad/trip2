<?php

namespace App\Http\Controllers;

use App\Destination;
use App\User;

class ExperimentsController extends Controller
{
    // public function index2()
    // {
    //     return layout('Offer')
    //         ->with(
    //             'content',
    //             collect()
    //                 ->push('<div style="background: red">aa</div>')
    //                 ->push(component('Dotmap')->with('height', '300px'))
    //         )
    //         ->render();
    // }

    public function list($d, $user)
    {
        return $d->map(function ($d) use ($user) {
            return collect()
        ->br(2)
        ->push(region('DestinationParents', $d->getAncestors()))
        ->push(
          component('Title')
            ->is('white')
            ->with('title', $d->name)
            ->with('route', route('destination.showSlug', [$d->slug]))
        )
        ->pushWhen(
          $user && $user->hasRole('admin'),
          component('Button')
            ->is('small')
            ->is('narrow')
            ->with('title', trans('content.action.edit.title'))
            ->with('route', route('destination.edit', [$d]))
        )
        ->pushWhen(
          $d->user,
          component('Title')
            ->is('semitransparent')
            ->is('smaller')
            ->with('title', $d->user ? $d->user->name . ':' : '')
        )
        ->push(
          component('Body')
            ->is('semitransparent')
            ->is('responsive')
            ->with('body', format_body($d->description))
        );
        });
    }

    public function index()
    {
        $user = request()->user();

        $continents = Destination::continents()
      ->get()
      ->sortBy('name');

        $countries = Destination::countries()
      ->get()
      ->sortBy('name');

        $cities = Destination::cities()
      ->get()
      ->sortBy('name');

        $places = Destination::places()
      ->get()
      ->sortBy('name');

        // $c = $continents->map(function ($d) use ($user) {
        //     return collect()
        //         ->br(2)
        //         ->push(region('DestinationParents', $d->getAncestors()))
        //         ->push(
        //             component('Title')
        //                 ->is('white')
        //                 ->with('title', $d->name)
        //                 ->with(
        //                     'route',
        //                     route('destination.showSlug', [$d->slug])
        //                 )
        //         )
        //         ->pushWhen(
        //             $user && $user->hasRole('admin'),
        //             component('Button')
        //                 ->is('small')
        //                 ->is('narrow')
        //                 ->with('title', trans('content.action.edit.title'))
        //                 ->with('route', route('destination.edit', [$d]))
        //         )
        //         ->pushWhen(
        //             $d->user,
        //             component('Title')
        //                 ->is('semitransparent')
        //                 ->is('smaller')
        //                 ->with('title', $d->user ? $d->user->name . ':' : '')
        //         )
        //         ->push(
        //             component('Body')
        //                 ->is('semitransparent')
        //                 ->is('responsive')
        //                 ->with('body', format_body($d->description))
        //         );
        // });

        return layout('Offer')
      ->with('color', 'yellow')
      ->with('header', region('OfferHeader'))
      ->with(
        'content',
        collect()
          ->push(
            component('Title')
              ->is('white')
              ->is('large')
              ->with('title', 'Maailmajaod')
          )
          ->merge($this->list($continents, $user))
          ->br(2)
          ->push(
            component('Title')
              ->is('white')
              ->is('large')
              ->with('title', 'Riigid')
          )
          ->merge($this->list($countries, $user))
          ->br(2)
          ->push(
            component('Title')
              ->is('white')
              ->is('large')
              ->with('title', 'Linnad')
          )
          ->merge($this->list($cities, $user))
          ->br(2)
          ->push(
            component('Title')
              ->is('white')
              ->is('large')
              ->with('title', 'Kohad')
          )
          ->merge($this->list($places, $user))
          ->flatten()
      )
      ->with('footer', region('FooterLight', ''))
      ->render();
    }

    public function flightIndex()
    {
        $t1 = '
### flightmap:TLL,HEL,JFK,POM

[[flightmap:TLL,HEL,JFK,POM]]

Tõime allpool välja valiku enamjaolt 4-5 päevasteks linnapuhkusteks. Piletihinnas sisaldub nii äraantav pagas kui toitlustamine lennuki pardal.';

        // $a = collect(['TLL', 'JFK', 'LAX'])->map(function ($a) {
        //     return collect(config('airports'))
        //         ->where('iata', $a)
        //         ->first();
        // });

        return layout('Two')
      ->with('content', collect()->push(component('Body')->with('body', format_body($t1))))
      ->with('sidebar', ['a'])
      ->render();
    }

    public function destinationIndex()
    {
        $ds = Destination::skip(50)
      ->take(50)
      ->get();

        return layout('Offer')
      ->with('color', 'blue')
      ->with(
        'content',
        $ds
          ->map(function ($d) {
              $name = $d->isContinent() && $d->vars()->facts() ? '' : json_encode($d->vars()->facts(), JSON_PRETTY_PRINT);

              $small = $d->vars()->facts()
              ? [
                [
                  'lat' => snap($d->vars()->facts()->lat),
                  'lon' => snap($d->vars()->facts()->lon)
                ]
              ]
              : false;

              return collect()
              ->push(
                component('Title')
                  //->is('white')
                  ->is('small')
                  ->with('title', $d->name)
              )
              //                             ->push(
              //                                 component('Code')
              //                                     ->is('gray')
              //                                     ->with(
              //                                         'code',
              //                                         "
              // id:   {$d->id}
              // name: {$d->name}
              // parent: {$d->getAncestors()->map->name}
              // { $name }
              //                                               "
              //                                     )
              //                             );
              ->push(
                component('Dotmap')
                  ->with('areas', [$d->id])
                  ->with('smalldots', $small)
              );
          })
          ->flatten()
      )
      ->render();
    }

    public function userIndex($id = 27)
    {
        $user = User::findOrFail($id);

        $been = $user
      ->vars()
      ->destinationHaveBeen()
      ->map(function ($f) {
          return $f->flaggable->id;
      })
      ->values();
        // dd($wantsToGo);

        return layout('Offer')
      ->with('color', 'cyan')
      ->with(
        'top',
        collect()
          ->push(
            component('HeaderLight')
              ->is('white')
              ->with(
                'navbar',
                component('Navbar')
                  ->with('search', component('NavbarSearch'))
                  ->with(
                    'logo',
                    component('Icon')
                      ->with('icon', 'tripee_logo')
                      ->with('width', 200)
                      ->with('height', 150)
                  )
                  ->with('navbar_desktop', region('NavbarDesktop', 'white'))
                  ->with('navbar_mobile', region('NavbarMobile'))
              )
          )

          ->push(
            component('Flex')->with('items', [
              component('UserImage')
                ->with('route', route('user.show', [$user]))
                ->with('image', $user->imagePreset('small_square'))
                ->with('rank', $user->vars()->rank)
                ->with('size', 152)
                ->with('border', 7)
            ])
          )
          ->br()
          ->push(
            component('Title')
              ->is('white')
              ->is('large')
              ->is('center')
              ->with('title', $user->vars()->name)
          )
      )
      ->with('footer', region('FooterLight', ''))
      ->render();
    }
}
