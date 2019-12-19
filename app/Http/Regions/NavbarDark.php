<?php

namespace App\Http\Regions;

class NavbarDark
{
  public function render()
  {
    return component('Navbar')
      ->with('search', component('NavbarSearch'))
      ->with(
        'logo',
        component('Icon')
          ->with('icon', 'tripee_logo_dark')
          ->with('width', 180)
          ->with('height', 120)
      )
      ->with('navbar_desktop', region('NavbarDesktop'))
      ->with('navbar_mobile', region('NavbarMobile'));
  }
}
