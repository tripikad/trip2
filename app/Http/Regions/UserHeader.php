<?php

namespace App\Http\Regions;

use App\Destination;

class UserHeader
{
  private function prepareActionsForUser($user, $loggedUser)
  {
    return collect()
      ->pushWhen(
        // Only owner sees the link, others can access it anyway and button is unneccesary
        $loggedUser && $loggedUser->id == $user->id,
        component('Button')
          ->is('cyan')
          ->with('title', trans('menu.user.activity'))
          ->with('route', route('user.show', [$user]))
      )
      ->pushWhen(
        $loggedUser && $loggedUser->hasRoleOrOwner('superuser', $loggedUser->id),
        component('Button')
          ->is('cyan')
          ->with('title', trans('menu.user.edit.profile'))
          ->with('route', route('user.edit', [$user]))
      )
      ->pushWhen(
        // Only the owner can see its own messages
        $loggedUser && $loggedUser->id == $user->id,
        component('Button')
          ->is('cyan')
          ->with('title', trans('menu.user.message'))
          ->with('route', route('message.index', [$user]))
      )
      ->pushWhen(
        $loggedUser && $loggedUser->hasRoleOrOwner('superuser', $loggedUser->id),
        component('Button')
          ->is('cyan')
          ->with('title', trans('menu.user.add.places'))
          ->with('route', route('user.destinations.edit', [$user]))
      );
  }

  public function render($user)
  {
    $countryCount = 195;

    $loggedUser = request()->user();

    $hasBeenContinents = $user
      ->vars()
      ->destinationHaveBeen()
      ->map->flaggable->filter(function ($d) {
        return $d->isContinent();
      });

    $hasBeenCountries = $user
      ->vars()
      ->destinationHaveBeen()
      ->map->flaggable->filter(function ($d) {
        return $d->isCountry();
      });

    $countryDots = $hasBeenCountries->pluck('id')->values();

    $hasBeenCities = $user
      ->vars()
      ->destinationHaveBeen()
      ->map->flaggable->filter(function ($d) {
        return $d->isCity();
      });

    $cityDots = $hasBeenCities
      ->map(function ($d) {
        return $d->vars()->snappedCoordinates();
      })
      ->filter()
      ->values();

    $wantsToGo = $user->vars()->destinationWantsToGo()->map->flaggable;

    return component('HeaderLight')
      ->with(
        'navbar',
        component('Navbar')
          ->is('white')
          ->with('search', component('NavbarSearch')->is('white'))
          ->with(
            'logo',
            component('Icon')
              ->with('icon', 'tripee_logo')
              ->with('width', 200)
              ->with('height', 150)
          )
          ->with('navbar_desktop', region('NavbarDesktop', 'white'))
          ->with('navbar_mobile', region('NavbarMobile', 'white'))
      )
      ->with(
        'content',
        collect()
          ->push(
            component('Dotmap')
              ->with('height', '300px')
              ->is('center')
              ->with('areas', $countryDots)
              ->with('smalldots', $cityDots)
          )
          ->push(region('UserHeaderImage', $user, $loggedUser))
          ->push(component('Center')->with('item', region('UserAbout', $user, $loggedUser)))
          ->br()
          ->push(region('UserStats', $user, $loggedUser))
          ->br()
          ->push(
            component('Body')
              ->is('white')
              ->is('responsive')
              ->with('body', format_body($user->vars()->description))
          )
          ->pushWhen($wantsToGo->count(), '&nbsp;')
          ->pushWhen(
            $hasBeenContinents->count(),
            component('Flex')
              ->with('align', 'center')
              ->with('gap', 1)
              ->with(
                'items',
                collect()
                  ->push(
                    component('Icon')
                      ->is('white')
                      ->with('size', 'xl')
                      ->with('icon', 'icon-star')
                  )
                  ->push(
                    component('Title')
                      ->is('white')
                      ->with(
                        'title',
                        trans('user.show.stat.continents', [
                          'count' => $hasBeenContinents->count()
                        ])
                      )
                  )
              )
          )
          ->pushWhen(
            $hasBeenContinents->count(),
            component('Flex')
              ->is('large')
              ->is('wrap')
              ->with('gap', 0.5)
              ->with(
                'items',
                $hasBeenContinents->map(function ($destination) {
                  return component('Tag')
                    ->is('white')
                    ->is('large')
                    ->with('title', $destination->name)
                    ->with('route', route('destination.showSlug', [$destination->slug]));
                })
              )
          )
          ->pushWhen(
            $hasBeenCountries->count(),
            component('Flex')
              ->with('align', 'center')
              ->with('gap', 1)
              ->with(
                'items',
                collect()
                  ->push(
                    component('Icon')
                      ->is('white')
                      ->with('size', 'xl')
                      ->with('icon', 'icon-pin')
                  )
                  ->push(
                    component('Title')
                      ->is('white')
                      ->with(
                        'title',
                        trans('user.show.stat.countries', [
                          'total_count' => $countryCount,
                          'count' => $hasBeenCountries->count(),
                          'percentage' => round(($hasBeenCountries->count() / $countryCount) * 100)
                        ])
                      )
                  )
              )
          )

          ->pushWhen(
            $hasBeenCountries->count(),
            component('Flex')
              ->is('wrap')
              ->is('large')
              ->with('gap', 0.5)
              ->with(
                'items',
                $hasBeenCountries->map(function ($destination) {
                  return component('Tag')
                    ->is('white')
                    ->is('large')
                    ->with('title', $destination->name)
                    ->with('route', route('destination.showSlug', [$destination->slug]));
                })
              )
          )
          ->pushWhen(
            $hasBeenCities->count(),
            component('Flex')
              ->with('align', 'center')
              ->with('gap', 1)
              ->with(
                'items',
                collect()
                  ->push(
                    component('Icon')
                      ->is('white')
                      ->with('size', 'xl')
                      ->with('icon', 'icon-pin')
                  )
                  ->push(
                    component('Title')
                      ->is('white')
                      ->with(
                        'title',
                        trans('user.show.stat.cities', [
                          'count' => $hasBeenCities->count()
                        ])
                      )
                  )
              )
          )
          ->pushWhen(
            $hasBeenCities->count(),
            component('Flex')
              ->is('wrap')
              ->is('large')
              ->with('gap', 0.5)
              ->with(
                'items',
                $hasBeenCities->map(function ($destination) {
                  return component('Tag')
                    ->is('white')
                    ->is('large')
                    ->with('title', $destination->name)
                    ->with('route', route('destination.showSlug', [$destination->slug]));
                })
              )
          )
          ->pushWhen(
            $wantsToGo->count(),
            component('Flex')
              ->with('align', 'center')
              ->with('gap', 1)
              ->with(
                'items',
                collect()
                  ->push(
                    component('Icon')
                      ->is('white')
                      ->with('size', 'xl')
                      ->with('icon', 'icon-star')
                  )
                  ->push(
                    component('Title')
                      ->is('white')
                      ->with('title', 'Tahab minna')
                  )
              )
          )
          ->pushWhen(
            $wantsToGo->count(),
            component('Flex')
              ->is('large')
              ->is('wrap')
              ->with('gap', 0.5)
              ->with(
                'items',
                $wantsToGo->map(function ($destination) {
                  return component('Tag')
                    ->is('white')
                    ->is('large')
                    ->with('title', $destination->name)
                    ->with('route', route('destination.showSlug', [$destination->slug]));
                })
              )
          )

          ->push(
            component('Flex')
              ->with('justify', 'center')
              ->with('items', $this->prepareActionsForUser($user, $loggedUser))
          )
      );
  }
}
