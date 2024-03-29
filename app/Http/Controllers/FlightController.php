<?php

namespace App\Http\Controllers;

use App\Services\FlightCalendarService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Log;
use Illuminate\Http\Request;
use App\Image;
use App\Topic;
use App\Content;
use App\Destination;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $currentDestination = $request->get('destination');
        $currentTopic = $request->get('topic');

        $sliceSize = 10;
        $flights = Content::getLatestPagedItems('flight', 2 * $sliceSize, $currentDestination, $currentTopic);

        $forums = Content::getLatestPagedItems('forum', 3, null, null, 'updated_at');
        $destinations = Destination::select('id', 'name')
            ->has('content_flights')
            ->get();
        //$topics = Topic::select('id', 'name')->get();

        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        return layout('Two')
            ->with('title', trans('content.flight.index.title'))
            ->with('head_title', trans('content.flight.index.title'))
            ->with('head_description', trans('site.description.flight'))
            ->with('head_image', Image::getSocial())

            ->with(
                'header',
                region(
                    'Header',
                    collect()
                        ->push(
                            component('Title')
                                ->is('white')
                                ->is('large')
                                ->with('title', trans('content.flight.index.title'))
                                ->with('route', route('flight.index'))
                        )
                        ->push(
                            region(
                                'FilterHorizontal',
                                $destinations,
                                null,
                                $currentDestination,
                                null,
                                $flights->currentPage(),
                                'flight.index'
                            )
                        )
                )
            )

            ->with(
                'content',
                collect()
                    ->push(component('Promo')->with('promo', 'flightoffer_list_top'))
                    //->push(component('Promo')->with('promo', 'mobile_small')->is('mobile-only'))
                    ->merge(
                        $flights->slice(0, $sliceSize)->map(function ($flight) {
                            return region('FlightRow', $flight);
                        })
                    )
                    //->push(component('Promo')->with('promo', 'body'))
                    ->push(component('Promo')->with('promo', 'body'))
                    ->merge(
                        $flights->slice($sliceSize)->map(function ($flight) {
                            return region('FlightRow', $flight);
                        })
                    )
                    ->push(region('Paginator', $flights, $currentDestination, $currentTopic))
            )

            ->with(
                'sidebar',
                collect()
                    ->push(region('FlightAbout'))
                    ->push(region('FlightNewsletterSubscribe'))
                    ->push(component('Promo')->with('promo', 'flightoffer_list_sidebar'))
                    ->push(component('Promo')->with('promo', 'sidebar_small'))
                    //->push(component('Promo')->with('promo', 'sidebar_large'))
                    ->push(component('Promo')->with('promo', 'sidebar_large'))
                    //->push(component('Promo')->with('promo', 'mobile_big')->is('mobile-only'))
                    ->push(component('AffHotelscombined'))
            )

            ->with(
                'bottom',
                collect()
                    ->push(region('FlightBottom', $forums, $travelmates, $news))
                    ->push(component('Promo')->with('promo', 'footer'))
                    //->push(component('Promo')->with('promo', 'mobile_small')->is('mobile-only'))
            )

            ->with(
                'footer',
                collect()
                    ->push(region('OfferSection'))
                    ->push(region('FooterLight'))
                    ->render()
                    ->implode('')
            )
            ->render();
    }

    public function show($slug)
    {
        $loggedUser = auth()->user();

        $flight = Content::getItemBySlug($slug, $loggedUser);

        if (!$flight) {
            abort(404);
        }

        $flight->vars()->add_view;

        $flights = Content::getLatestItems('flight', 4);
        $forums = Content::getLatestPagedItems('forum', 3, null, null, 'updated_at');
        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        return layout('Two')
            ->with('title', trans('content.flight.index.title'))
            ->with('head_title', $flight->vars()->title)
            ->with('head_description', $flight->vars()->description)

            // Temporarily disabled since og:image tag does not allow to select custom images in FB
            //->with('head_image', $flight->getHeadImage())

            ->with(
                'header',
                region(
                    'Header',
                    collect()
                        ->push(
                            component('Link')
                                ->is('white')
                                ->with('title', trans('content.flight.show.action.all'))
                                ->with('route', route('flight.index'))
                        )
                        ->push(
                            component('Title')
                                ->is('white')
                                ->is('large')
                                ->is('shadow')
                                ->with('title', $flight->vars()->title)
                        )
                        ->push(
                            component('Meta')->with(
                                'items',
                                collect()
                                    ->push(
                                        component('MetaLink')
                                            ->is('white')
                                            ->with('title', $flight->vars()->created_at)
                                    )
                                    ->merge(
                                        $flight->destinations->map(function ($destination) {
                                            return component('Tag')
                                                ->is('white')
                                                ->with('title', $destination->name)
                                                ->with('route', route('destination.showSlug', [$destination->slug]));
                                        })
                                    )
                                    ->pushWhen(
                                        $loggedUser && $loggedUser->hasRole('admin', $flight->user->id),
                                        component('MetaLink')
                                            ->is('green')
                                            ->is('filled')
                                            ->with('title', trans('content.action.edit.title'))
                                            ->with('route', route('flight.edit', [$flight]))
                                    )
                                    ->pushWhen(
                                        $loggedUser && $loggedUser->hasRole('admin'),
                                        component('Form')
                                            ->with(
                                                'route',
                                                route('content.status', [$flight->type, $flight, 1 - $flight->status])
                                            )
                                            ->with(
                                                'fields',
                                                collect()->push(
                                                    component('FormLink')
                                                        ->is('pink')
                                                        ->is('filled')
                                                        ->with(
                                                            'title',
                                                            trans("content.action.status.$flight->status.title")
                                                        )
                                                )
                                            )
                                    )
                            )
                        ),
                    $flight->getHeadImage(),
                    'high'
                )
            )

            ->with(
                'top',
                collect()->pushWhen(
                    !$flight->status,
                    component('HeaderUnpublished')->with('title', trans('content.show.unpublished'))
                )
            )

            ->with(
                'content',
                collect()
                    //->push(component('Promo')->with('promo', 'body'))
                    ->push(component('Promo')->with('promo', 'body'))
                    //->push(component('Promo')->with('promo', 'mobile_small')->is('mobile-only'))
                    ->push(
                        component('Body')
                            ->is('responsive')
                            ->with('body', $flight->vars()->body)
                    )
                    ->push(region('Share'))
                    ->merge(
                        $flight->comments->map(function ($comment) {
                            return region('Comment', $comment);
                        })
                    )
                    ->pushWhen($loggedUser && $loggedUser->hasRole('regular'), region('CommentCreateForm', $flight))
                    //->push(component('Promo')->with('promo', 'body'))
                    ->push(component('Promo')->with('promo', 'body'))
                    //->push(component('Promo')->with('promo', 'mobile_small')->is('mobile-only'))
                    ->push(
                        component('Block')
                            ->with('title', trans('frontpage.index.flight.title'))
                            ->with(
                                'content',
                                $flights->map(function ($flight) {
                                    return region('FlightRow', $flight);
                                })
                            )
                    )
            )

            ->with(
                'sidebar',
                collect()
                    ->push(region('FlightAbout'))
                    ->push(region('FlightNewsletterSubscribe'))
                    ->push(component('Promo')->with('promo', 'sidebar_small'))
                    //->push(component('Promo')->with('promo', 'sidebar_large'))
                    ->push(component('Promo')->with('promo', 'sidebar_large'))
                    //->push(component('Promo')->with('promo', 'mobile_big')->is('mobile-only'))
                    ->push(component('AffiliateSearch'))
                    ->push(component('AffRentalcars'))
                    ->push(component('AffBookingSearch'))
            )

            ->with(
                'bottom',
                collect()
                    ->push(region('FlightBottom', $forums, $travelmates, $news))
                    ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with(
                'footer',
                collect()
                    ->push(region('OfferSection'))
                    ->push(region('FooterLight'))
                    ->render()
                    ->implode('')
            )
            ->render();
    }

    public function create()
    {
        $destinations = Destination::select('id', 'name')
            ->orderBy('name')
            ->get();

        return layout('Two')
            ->with(
                'header',
                region(
                    'Header',
                    collect()->push(
                        component('Title')
                            ->is('white')
                            ->with('title', trans('content.flight.index.title'))
                            ->with('route', route('flight.index'))
                    )
                )
            )

            ->with(
                'content',
                collect()
                    ->push(component('Title')->with('title', trans('content.flight.create.title')))
                    ->push(
                        component('Form')
                            ->with('route', route('flight.store'))
                            ->with(
                                'fields',
                                collect()
                                    ->push(
                                        component('FormTextfield')
                                            ->is('large')
                                            ->with('title', trans('content.flight.edit.field.title.title'))
                                            ->with('name', 'title')
                                            ->with('value', old('title'))
                                    )
                                    ->push(
                                        component('FormImageId')
                                            ->with('title', trans('content.flight.edit.field.image_id.title'))
                                            ->with('name', 'image_id')
                                            ->with('value', old('image_id'))
                                    )
                                    ->push(
                                        component('FormTextarea')
                                            ->is('hidden')
                                            ->with('name', 'body')
                                            ->with('value', old('body'))
                                    )
                                    ->push(
                                        component('FormEditor')
                                            ->with('title', trans('content.flight.edit.field.body.title2'))
                                            ->with('name', 'body')
                                            ->with('value', [old('body')])
                                            ->with('rows', 10)
                                    )
                                    ->push(
                                        component('FormSelectMultiple')
                                            ->with('name', 'destinations')
                                            ->with('options', $destinations)
                                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                                    )
                                    ->push(component('FormButton')->with('title', trans('content.create.title')))
                            )
                    )
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function store()
    {
        $loggedUser = request()->user();

        $rules = [
            'title' => 'required',
            'body' => 'required'
        ];

        $this->validate(request(), $rules);

        $flight = $loggedUser->contents()->create([
            'title' => request()->title,
            'body' => request()->body,
            'type' => 'flight',
            'status' => 1
        ]);

        $flight->destinations()->attach(request()->destinations);

        if ($imageToken = request()->image_id) {
            $imageId = str_replace(['[[', ']]'], '', $imageToken);
            $flight->images()->attach([$imageId]);
        }

        Log::info('New content added', [
            'user' => $flight->user->name,
            'title' => $flight->title,
            'type' => $flight->type,
            'body' => $flight->body,
            'link' => route('news.show', [$flight->slug])
        ]);

        return redirect()
            ->route('flight.index')
            ->with(
                'info',
                trans('content.store.info', [
                    'title' => $flight->title
                ])
            );
    }

    public function edit($id)
    {
        $flight = Content::findOrFail($id);
        $destinations = Destination::select('id', 'name')
            ->orderBy('name')
            ->get();

        return layout('Two')
            ->with(
                'header',
                region(
                    'Header',
                    collect()->push(
                        component('Title')
                            ->is('white')
                            ->with('title', trans('content.flight.index.title'))
                            ->with('route', route('flight.index'))
                    )
                )
            )

            ->with(
                'content',
                collect()
                    ->push(component('Title')->with('title', trans('content.flight.edit.title')))
                    ->push(
                        component('Form')
                            ->with('route', route('flight.update', [$flight]))
                            ->with('method', 'PUT')
                            ->with(
                                'fields',
                                collect()
                                    ->push(
                                        component('FormTextfield')
                                            ->is('large')
                                            ->with('title', trans('content.flight.edit.field.title.title'))
                                            ->with('name', 'title')
                                            ->with('value', old('title', $flight->title))
                                    )
                                    ->push(
                                        component('FormImageId')
                                            ->with('title', trans('content.flight.edit.field.image_id.title'))
                                            ->with('name', 'image_id')
                                            ->with('value', old('image_id', $flight->image_id))
                                    )
                                    ->push(
                                        component('FormTextarea')
                                            ->is('hidden')
                                            ->with('name', 'body')
                                            ->with('value', old('body', $flight->body))
                                    )
                                    ->push(
                                        component('FormEditor')
                                            ->with('title', trans('content.flight.edit.field.body.title2'))
                                            ->with('name', 'body')
                                            ->with('value', [old('body', $flight->body)])
                                            ->with('rows', 10)
                                    )
                                    ->push(
                                        component('FormSelectMultiple')
                                            ->with('name', 'destinations')
                                            ->with('options', $destinations)
                                            ->with('value', $flight->destinations->pluck('id'))
                                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                                    )
                                    ->push(component('FormButton')->with('title', trans('content.edit.submit.title')))
                            )
                    )
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function update($id)
    {
        $flight = Content::findOrFail($id);

        $rules = [
            'title' => 'required',
            'body' => 'required'
        ];

        $this->validate(request(), $rules);

        $flight->update([
            'title' => request()->title,
            'body' => request()->body
        ]);

        $flight->destinations()->sync(request()->destinations ?: []);

        if ($imageToken = request()->image_id) {
            $imageId = str_replace(['[[', ']]'], '', $imageToken);
            $flight->images()->sync([$imageId] ?: []);
        }

        return redirect()
            ->route('flight.show', [$flight->slug])
            ->with(
                'info',
                trans('content.update.info', [
                    'title' => $flight->title
                ])
            );
    }

    /**
     * @param FlightCalendarService $service
     * @param Request $request
     * @return JsonResponse|null
     */
    public function getMonthData(FlightCalendarService $service, Request $request) : ?JsonResponse
    {
        $startMonth = $request->get('startMonth');
        $endMonth = $request->get('endMonth');
        $startCode = $request->get('startCode');
        $endCode = $request->get('endCode');

        if ($startMonth && $endMonth && $startCode && $endCode) {
            $startMonth = Carbon::createFromFormat('Y-m-d', $startMonth . '-01');
            $endMonth = Carbon::createFromFormat('Y-m-d', $endMonth . '-01');

            if ($startMonth->isValid() && $endMonth->isValid() && $startMonth <= $endMonth)
                return $service->getMonthData($startMonth, $endMonth, $startCode, $endCode);

            return null;
        }

        return null;
    }

    /**
     * @param FlightCalendarService $service
     * @param Request $request
     * @return JsonResponse|null
     */
    public function getLivePrice(FlightCalendarService $service, Request $request) : ?JsonResponse
    {
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        $startCode = $request->get('startCode');
        $endCode = $request->get('endCode');

        if ($startDate && $endDate && $startCode && $endCode) {
            $startDate = Carbon::createFromFormat('Y-m-d', $startDate);
            $endDate = Carbon::createFromFormat('Y-m-d', $endDate);

            if ($startDate->isValid() && $endDate->isValid() && $startDate <= $endDate)
                return $service->getLivePrice($startDate, $endDate, $startCode, $endCode);

            return null;
        }

        return null;
    }
}
