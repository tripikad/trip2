<?php

namespace App\Http\Regions;

class CompanyCard
{
  public function render($company)
  {
    return component('Flex')
      ->with('align', 'center')
      ->with(
        'items',
        collect()
          ->push(
            component('Title')
              ->is('white')
              ->is('small')
              ->with('title', $company->name)
              ->with('route', route('company.show', $company))
          )
          ->push(
            component('Button')
              ->is('orange')
              ->is('small')
              ->is('narrow')
              ->with('title', trans('company.index.edit'))
              ->with('route', route('company.edit', [$company, 'redirect' => 'company.admin.index']))
          )
      );
  }
}
