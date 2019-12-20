<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;

class ExperimentsController extends Controller
{
  public function index($id = null)
  {
    $destination = $id ? Destination::findOrFail($id) : null;

    $photos = Content::getLatestPagedItems('photo', 5 * 20, $id);
    $loggedUser = request()->user();

    return layout('Full')
      ->withItems(
        collect()
          ->push(
            component('Section')
              ->withPadding(2)
              ->withTag('header')
              ->withItems(collect()->push(region('NavbarDark')))
          )
          ->push(
            component('Section')
              ->withPadding(2)
              ->withGap(1)
              ->withAlign('center')
              ->withItems(
                collect()
                  ->push(
                    component('Title')
                      ->is('large')
                      ->withTitle(trans('content.photo.index.title') . ($destination ? ": $destination->name" : ''))
                  )
                  ->pushWhen(
                    $loggedUser && $loggedUser->hasRole('regular'),
                    component('Button')
                      ->is('narrow')
                      ->with('title', trans('content.photo.create.title'))
                      ->with('route', route('photo.create'))
                  )
                  ->spacer()
              )
          )
          ->push(
            component('Section')->withItems(
              collect()->push(
                component('Grid')
                  ->withCols(5)
                  ->withItems(
                    $photos->map(function ($photo) use ($loggedUser) {
                      return component('Photo')
                        ->vue()
                        ->withImage($photo->imagePreset('small_square'))
                        ->withLargeImage($photo->imagePreset('large'))
                        ->withMeta(
                          component('Flex')
                            ->withJustify('center')
                            ->withItems(
                              collect()
                                ->push(
                                  component('Title')
                                    ->is('smallest')
                                    ->is('blue')
                                    ->withTitle($photo->user->name)
                                    ->withRoute(route('user.show', [$photo->user]))
                                    ->withExternal(true)
                                )
                                ->push(
                                  component('Title')
                                    ->is('smallest')
                                    ->is('white')
                                    ->withTitle($photo->title)
                                )
                                ->pushWhen(
                                  $loggedUser && $loggedUser->hasRole('admin'),
                                  component('PublishButton')
                                    ->withPublished($photo->status)
                                    ->withPublishRoute(route('content.status', [$photo->type, $photo, 1]))
                                    ->withUnpublishRoute(route('content.status', [$photo->type, $photo, 0]))
                                )
                            )
                            ->render()
                        );
                    })
                  )
              )
            )
          )
          ->push(
            component('Section')
              ->withPadding(2)
              ->withItems(region('Paginator', $photos))
          )
          ->push(
            component('Section')
              ->withPadding(2)
              ->withTag('footer')
              ->withItems(region('FooterLight'))
          )
      )
      ->render();
  }

  public function socialIndex()
  {
    $user = null;

    $offer = Offer::find(7);

    return layout('Full')
      ->withItems(
        component('Section')
          ->withWidth('600px') // 1200
          ->withHeight('335px') // 675
          ->withBackground('blue')
          ->withAlign('center')
          ->withImage('./photos/map.png')
          ->withItems(
            collect()
              ->spacer(2)
              ->push(
                component('Icon')
                  ->with('icon', 'tripee_logo')
                  ->with('width', 320)
                  ->with('height', 110)
              )
              ->push(
                component('Title')
                  ->is('large')
                  ->is('white')
                  ->is('center')
                  ->withTitle(trans('frontpage.index.offer.title'))
                  ->withRoute(route('offer.index'))
              )
              ->spacer(3)
              ->push(
                component('Title')
                  ->is('small')
                  ->is('white')
                  ->is('center')
                  ->withTitle(trans('Hulludest seiklustest<br>rannapuhkuseni'))
                  ->withRoute(route('offer.index'))
              )
          )
      )
      ->render();
  }
}
