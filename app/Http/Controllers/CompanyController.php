<?php

namespace App\Http\Controllers;

use App\Company;
use App\Destination;
use App\Services\TravelOfferService;
use App\Services\TravelPackageService;
use App\TravelOffer;
use Hash;
use Carbon\Carbon;
use App\User;
use App\Image;
use App\Offer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    /**
     * @param $slug
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function profilePublic($slug, Request $request)
    {
        $company = Company::whereSlug($slug)->first();
        if (!$company) {
            abort(404);
        }

        //todo: return view and data based on company type

        $company->loadMissing('user');
        $company->loadMissing('travelOffers');
        $routeName = $request->route()->getName();

        $items = [
            [
                'title' => 'Tutvustus',
                'route' => route('company.profile.public', ['slug' => $company->slug]),
                'active' => $routeName !== 'company.profile.public' ? $routeName === 'company.profile.public' : '#',
                'count' => null
            ],
            [
                'title' => 'Pakkumised',
                'route' => $routeName !== 'company.offers.public' ? route('company.offers.public', ['slug' => $company->slug]) : '#',
                'active' => $routeName === 'company.offers.public',
                'count' => 12
            ]
        ];

        return view('pages.company.profile-public', [
            'company' => $company,
            'user' => $company->user,
            'items' => $items
        ]);
    }

    /**
     * @param string $slug
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function offersPublic(string $slug, Request $request)
    {
        $company = Company::whereSlug($slug)->first();
        if (!$company) {
            abort(404);
        }

        //todo: return view and data based on company type

        $company->loadMissing('user');
        //$company->loadMissing('activeVacationPackages');
        $items = [
            [
                'title' => 'Tutvustus',
                'route' => route('company.profile.public', ['slug' => $company->slug]),
                'active' => false,
                'count' => null
            ],
            [
                'title' => 'Pakkumised',
                'route' => '#',
                'active' => true,
                'count' => 12
            ]
        ];

        return view('pages.company.offers-public', [
            'company' => $company,
            'user' => $company->user,
            //'packages' => $company->activeVacationPackages,
            'items' => $items
        ]);
    }

    /**
     * @param Company $company
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function profile(Company $company, Request $request)
    {
        $company->loadMissing('user');
        $company->loadMissing(['travelOffers' => function ($query) {
            $query->orderBy('name', 'ASC');
        }]);

        return view('pages.company.profile', [
            'company' => $company,
            'user' => $company->user
        ]);
    }

    /**
     * @param Company $company
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function editProfile(Company $company, Request $request)
    {
        $company->loadMissing('user');
        $routeName = $request->route()->getName();

        $items = [
            [
                'title' => 'Pakkumised',
                'route' => route('company.profile', ['company' => $company]),
                'active' => $routeName !== 'company.profile' ? $routeName === 'company.profile' : '#',
                'count' => 54
            ],
            [
                'title' => 'Minu info',
                'route' => $routeName !== 'company.edit_profile' ? route('company.edit_profile', ['company' => $company]) : '#',
                'active' => $routeName === 'company.edit_profile',
                'count' => null
            ]
        ];

        return view('pages.company.profile-edit', [
            'company' => $company,
            'user' => $company->user,
            'items' => $items
        ]);
    }

    /**
     * @param Company $company
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function updateProfile(Company $company, Request $request)
    {
        $user = $company->user;
        $maxFileSize = config('site.maxfilesize') * 1024;

        $rules = [
            'company_name' => 'required|max:64|unique:companies,name,' . $company->id,
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'sometimes|confirmed|min:6',
            'password_confirmation' => 'required_with:password|same:password',
            'description' => 'min:2',
            'facebook' => 'url',
            'homepage' => 'url',
            'file' => "image|max:$maxFileSize"
        ];

        $this->validate($request, $rules);

        $data = [
            'email' => $request->email,
            'description' => $request->description,
            'contact_facebook' => $request->facebook,
            'contact_homepage' => $request->homepage
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $company->slug = null;
        $company->update([
            'name' => $request->company_name
        ]);

        if ($request->hasFile('logo')) {
            $filename =
                'company_logo-' .
                $user->id .
                '.' .
                $request
                    ->file('logo')
                    ->getClientOriginalExtension();

            $filename = Image::storeImageFile($request->file('logo'), $filename);

            $user->images()->delete();
            $user->images()->create(['filename' => $filename]);
        }

        return redirect()
            ->route('company.profile.public', ['slug' => $company->slug])
            ->with('info', trans('user.update.info'));
    }

    /**
     * @param array $hotels
     * @return mixed
     */
    private function formatHotelRating($hotels): array
    {
        array_walk($hotels, function(&$hotel, $key) use (&$hotels) {
            if (isset($hotel['star']))
                $hotel['star'] = (int) $hotel['star'];
        });

        return $hotels;
    }

    /**
     * @param Company $company
     * @param Request $request
     * @param TravelOffer|null $travelOffer
     * @return Application|Factory|\Illuminate\View\View
     */
    protected function travelPackageForm(Company $company, Request $request, TravelOffer $travelOffer = null)
    {
        $service = new TravelOfferService();
        $destinations = Destination::select('id', 'name')->where('depth', 2)->get()->toArray(); //cities

        $submitRoute = $travelOffer
            ? route('company.update_travel_offer', ['company' => $company, 'travelOffer' => $travelOffer])
            : route('company.store_travel_offer', ['company' => $company]);

        return view('pages.travel_package.form', [
            'title' => $travelOffer ? 'Muuda paketireisi' : 'Lisa uus paketireis',
            'submitRoute' => $submitRoute,
            'company' => $company,
            'user' => $company->user,
            'destinationOptions' => $destinations,
            'accommodationOptions' => $service->getAccommodationOptions(),
            'hotels' => $this->formatHotelRating(old('hotel', $travelOffer ? $travelOffer->hotels->toArray() : [])),
            'offer' => $travelOffer
        ]);
    }

    /**
     * @param string $type
     * @param Company $company
     * @param Request $request
     * @param TravelOffer|null $travelOffer
     * @return Application|Factory|\Illuminate\View\View|int
     */
    protected function getTravelOfferFormByType(string $type, Company $company, Request $request, TravelOffer $travelOffer = null)
    {
        //return view by type
        switch ($type) {
            case 'package':
                return $this->travelPackageForm($company, $request, $travelOffer);
            /*case 'ski':
                return '';
            case 'round':
                return '';*/
            default:
                abort(403);
        }

        return 404;
    }

    /**
     * @param Company $company
     * @param Request $request
     * @return false|Application|Factory|\Illuminate\View\View
     */
    public function addTravelOffer(Company $company, Request $request)
    {
        $type = $request->get('type');
        if (!$type)
            abort(403);

        return $this->getTravelOfferFormByType($type,  $company, $request);
    }

    /**
     * @param Company $company
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeTravelOffer(Company $company, Request $request): RedirectResponse
    {
        $type = $request->post('type');
        if (!$type)
            abort(403);

        $result = null;
        switch ($type) {
            case 'package':
                $result = TravelPackageService::storeTravelPackage($company, $request);
                break;
            /*case 'ski':
                return '';
            case 'round':
                return '';*/
            default:
                abort(403);
        }

        if ($result && $result instanceof TravelOffer) {
            return Redirect::route('company.profile', ['company' => $company])
                ->with('info', 'Reisipakkumine loodud');
        } else {
            return Redirect::back()
                ->withInput($request->input())
                ->withErrors($result);
        }
    }

    /**
     * @param Company $company
     * @param TravelOffer $travelOffer
     * @param Request $request
     * @return Application|Factory|\Illuminate\View\View|int
     */
    public function editTravelOffer(Company $company, TravelOffer $travelOffer, Request $request)
    {
        $travelOffer->loadMissing('hotels');
        return $this->getTravelOfferFormByType($travelOffer->type,  $company, $request, $travelOffer);
    }

    /**
     * @param Company $company
     * @param TravelOffer $travelOffer
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateTravelOffer(Company $company, TravelOffer $travelOffer, Request $request)
    {
        $type = $request->post('type');
        if (!$type)
            abort(403);

        $result = null;
        switch ($type) {
            case 'package':
                $result = TravelPackageService::updateTravelPackage($company, $request, $travelOffer);
                break;
            /*case 'ski':
                return '';
            case 'round':
                return '';*/
            default:
                abort(403);
        }

        if ($result && $result instanceof TravelOffer) {
            return Redirect::route('company.profile', ['company' => $company])
                ->with('info', 'Reisipakkumine muudetud');
        } else {
            return Redirect::back()
                ->withInput($request->input())
                ->withErrors($result);
        }
    }



    public function index()
    {
        $loggedUser = request()->user();

        $offers = $loggedUser
            ->offers()
            ->orderBy('start_at')
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->get();

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
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('NavbarLight')))
                    )
                    ->push(
                        component('Section')
                            ->withBackground('blue')
                            ->withPadding(2)
                            ->withGap(2)
                            ->withWidth(styles('tablet-width'))
                            ->withItems(
                                collect()
                                    ->push(
                                        component('Title')
                                            ->is('white')
                                            ->is('large')
                                            ->with('title', trans('company.index.title'))
                                    )
                                    ->push(region('CompanyOffersButtons', $loggedUser))
                                    ->spacer(4)
                                    ->push(region('CompanyOffers', $offers))
                            )
                    )
                    ->push(
                        component('Section')
                            ->withTag('footer')
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('FooterLight', '')))
                    )
            )
            ->render();
    }

    public function adminIndex()
    {
        $companies = User::whereCompany(true)->get();

        $offers = Offer::orderBy('start_at')
            ->with(['user:id,name', 'startDestinations', 'endDestinations'])
            ->take(100)
            ->get();

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
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('NavbarLight')))
                    )
                    ->push(
                        component('Section')
                            ->withBackground('blue')
                            ->withPadding(2)
                            ->withGap(2)
                            ->withWidth(styles('tablet-width'))
                            ->withItems(
                                collect()
                                    ->push(
                                        component('Title')
                                            ->is('white')
                                            ->is('large')
                                            ->with('title', trans('company.admin.index.title'))
                                    )
                                    ->push(
                                        component('Button')
                                            ->is('narrow')
                                            ->with('title', trans('company.create'))
                                            ->with(
                                                'route',
                                                route('company.create', ['redirect' => 'company.admin.index'])
                                            )
                                    )
                                    ->spacer(2)
                                    ->push(region('CompanyAdminTable', $companies))
                                    ->spacer(4)
                                    ->push(
                                        component('Title')
                                            ->is('large')
                                            ->is('white')
                                            ->with('title', trans('company.admin.index.offer'))
                                    )
                                    ->spacer(0.5)
                                    ->push(region('CompanyOffersAdmin', $offers))
                            )
                    )
                    ->push(
                        component('Section')
                            ->withTag('footer')
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('FooterLight', '')))
                    )
            )
            ->render();
    }

    public function show($id)
    {
        $user = User::whereCompany(true)->findOrFail($id);
        return redirect()->route('offer.index', ['user_id' => $user->id]);
    }

    public function create()
    {
        $loggedUser = request()->user();

        return layout('Full')
            // @LAUNCH Remove
            ->withHeadRobots('noindex')
            ->withTransparency(true)
            ->withTitle(trans('offer.index'))
            ->withItems(
                collect()
                    ->push(
                        component('Section')
                            ->withPadding(2)
                            ->withTag('header')
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('NavbarLight')))
                    )
                    ->push(
                        component('Section')
                            ->withBackground('blue')
                            ->withPadding(2)
                            ->withWidth(styles('tablet-width'))
                            ->withItems(
                                component('Title')
                                    ->is('white')
                                    ->is('large')
                                    ->withTitle(trans('company.create.title'))
                            )
                    )
                    ->push(
                        component('Section')
                            ->withBackground('blue')
                            ->withInnerBackground('white')
                            ->withInnerPadding(2)
                            ->withWidth(styles('tablet-width'))
                            ->withItems(
                                component('Form')
                                    ->with('route', route('company.store'))
                                    ->with('files', true)
                                    ->with(
                                        'fields',
                                        collect()
                                            ->push(
                                                component('Title')
                                                    ->is('small')
                                                    ->is('blue')
                                                    ->with('title', trans('company.edit.credentials'))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->is('large')
                                                    ->with('title', trans('company.edit.name.title'))
                                                    ->with('name', 'name')
                                                    ->with('value', old('name'))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->is('large')
                                                    ->with('title', trans('company.edit.company_name.title'))
                                                    ->with('name', 'company_name')
                                                    ->with('value', old('company_name'))
                                            )

                                            ->push(
                                                component('FormPassword')
                                                    ->is('large')
                                                    ->with('title', trans('company.create.password.title'))
                                                    ->with('name', 'password')
                                                    ->with('value', '')
                                            )
                                            ->push(
                                                component('FormPassword')
                                                    ->is('large')
                                                    ->with('title', trans('company.create.password_confirmation.title'))
                                                    ->with('name', 'password_confirmation')
                                                    ->with('value', '')
                                            )
                                            ->push(
                                                component('Title')
                                                    ->is('small')
                                                    ->is('blue')
                                                    ->with('title', trans('company.edit.about'))
                                            )
                                            ->push(component('FormUpload')->with('name', 'file'))
                                            ->push(
                                                component('FormTextarea')
                                                    ->with('rows', 4)
                                                    ->with('title', trans('company.edit.description.title'))
                                                    ->with('name', 'description')
                                                    ->with('value', old('description'))
                                            )
                                            ->push(
                                                component('Title')
                                                    ->is('small')
                                                    ->is('blue')
                                                    ->with('title', trans('company.edit.contacts.title'))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->is('large')
                                                    ->with('title', trans('company.edit.email.title'))
                                                    ->with('name', 'email')
                                                    ->with('value', old('email'))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->with('title', trans('company.edit.homepage.title'))
                                                    ->with('name', 'contact_homepage')
                                                    ->with('value', old('contact_homepage'))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->with('title', trans('company.edit.facebook.title'))
                                                    ->with('name', 'contact_facebook')
                                                    ->with('value', old('contact_facebook'))
                                            )
                                            ->push(
                                                component('FormButton')
                                                    ->is('wide')
                                                    ->is('large')
                                                    ->with('title', trans('company.create.submit'))
                                            )
                                    )
                            )
                    )
                    ->push(
                        component('Section')
                            ->withTag('footer')
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('FooterLight', '')))
                    )
            )
            ->render();
    }

    public function store()
    {
        $maxfilesize = config('site.maxfilesize') * 1024;

        $rules = [
            'name' => 'required|unique:users,name',
            'company_name' => 'required|unique:users,real_name',
            'email' => 'required|unique:users,email',
            'password' => 'required|sometimes|confirmed|min:6',
            'password_confirmation' => 'required_with:password|same:password',
            'description' => 'min:2',
            'contact_facebook' => 'url',
            'contact_homepage' => 'url',
            'file' => "image|max:$maxfilesize"
        ];

        $this->validate(request(), $rules);

        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
            'real_name' => request()->company_name,
            'real_name_show' => 1,
            'notify_message' => 0,
            'notify_follow' => 0,
            'description' => request()->description,
            'contact_facebook' => request()->contact_facebook,
            'contact_instagram' => '',
            'contact_twitter' => '',
            'contact_homepage' => request()->contact_homepage,
            'active_at' => Carbon::now(),
            'verified' => 1,
            'company' => true
        ]);

        if (request()->hasFile('file')) {
            $filename =
                'picture-' .
                $user->id .
                '.' .
                request()
                    ->file('file')
                    ->getClientOriginalExtension();

            $filename = Image::storeImageFile(request()->file('file'), $filename);

            $user->images()->delete();
            $user->images()->create(['filename' => $filename]);
        }

        return redirect()
            ->route('company.index')
            ->with('info', trans('company.create.info'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

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
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('NavbarLight')))
                    )
                    ->push(
                        component('Section')
                            ->withBackground('blue')
                            ->withPadding(2)
                            ->withWidth(styles('tablet-width'))
                            ->withItems(
                                component('Title')
                                    ->is('white')
                                    ->is('large')
                                    ->withTitle(trans('company.edit.title'))
                            )
                    )
                    ->push(
                        component('Section')
                            ->withBackground('blue')
                            ->withInnerBackground('white')
                            ->withInnerPadding(2)
                            ->withWidth(styles('tablet-width'))
                            ->withItems(
                                component('Form')
                                    ->with('route', route('company.update', [$user]))
                                    ->with('method', 'PUT')
                                    ->with('files', true)
                                    ->with(
                                        'fields',
                                        collect()
                                            ->push(
                                                component('Title')
                                                    ->is('small')
                                                    ->is('blue')
                                                    ->with('title', trans('company.edit.credentials'))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->is('large')
                                                    ->with('title', trans('company.edit.name.title'))
                                                    ->with('name', 'name')
                                                    ->with('value', old('name', $user->name))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->is('large')
                                                    ->with('title', trans('company.edit.company_name.title'))
                                                    ->with('name', 'company_name')
                                                    ->with('value', old('company_name', $user->real_name))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->is('large')
                                                    ->with('title', trans('company.edit.email.title'))
                                                    ->with('name', 'email')
                                                    ->with('value', old('email', $user->email))
                                            )
                                            ->push(
                                                component('FormPassword')
                                                    ->is('large')
                                                    ->with('title', trans('company.edit.password.title'))
                                                    ->with('name', 'password')
                                                    ->with('value', '')
                                            )
                                            ->push(
                                                component('FormPassword')
                                                    ->is('large')
                                                    ->with('title', trans('company.edit.password_confirmation.title'))
                                                    ->with('name', 'password_confirmation')
                                                    ->with('value', '')
                                            )
                                            ->push(
                                                component('Title')
                                                    ->is('small')
                                                    ->is('blue')
                                                    ->with('title', trans('company.edit.about'))
                                            )
                                            ->push(component('FormUpload')->with('name', 'file'))
                                            ->push(
                                                component('FormTextarea')
                                                    ->with('rows', 4)
                                                    ->with('title', trans('company.edit.description.title'))
                                                    ->with('name', 'description')
                                                    ->with('value', old('description', $user->description))
                                            )
                                            ->push(
                                                component('Title')
                                                    ->is('small')
                                                    ->is('blue')
                                                    ->with('title', trans('company.edit.contacts.title'))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->with('title', trans('company.edit.homepage.title'))
                                                    ->with('name', 'contact_homepage')
                                                    ->with('value', old('contact_homepage', $user->contact_homepage))
                                            )
                                            ->push(
                                                component('FormTextfield')
                                                    ->with('title', trans('company.edit.facebook.title'))
                                                    ->with('name', 'contact_facebook')
                                                    ->with('value', old('contact_facebook', $user->contact_facebook))
                                            )
                                            ->pushWhen(
                                                request()->has('redirect'),
                                                component('FormHidden')
                                                    ->with('name', 'redirect')
                                                    ->with('value', request()->redirect)
                                            )
                                            ->push(
                                                component('FormButton')
                                                    ->is('wide')
                                                    ->is('large')
                                                    ->with('title', trans('company.edit.submit'))
                                            )
                                    )
                            )
                    )
                    ->push(
                        component('Section')
                            ->withTag('footer')
                            ->withBackground('blue')
                            ->withItems(collect()->push(region('FooterLight', '')))
                    )
            )
            ->render();
    }

    public function update($id)
    {
        $user = User::findorFail($id);
        $maxfilesize = config('site.maxfilesize') * 1024;

        $rules = [
            'name' => 'required|unique:users,name,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'sometimes|confirmed|min:6',
            'password_confirmation' => 'required_with:password|same:password',
            'description' => 'min:2',
            'contact_facebook' => 'url',
            'contact_homepage' => 'url',
            'file' => "image|max:$maxfilesize"
        ];

        $this->validate(request(), $rules);

        $user->update([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
            'real_name' => request()->company_name,
            'real_name_show' => request()->real_name_show ? 0 : 1,
            'notify_message' => request()->notify_message ? 1 : 0,
            'notify_follow' => request()->notify_follow ? 1 : 0,
            'description' => request()->description,
            'contact_facebook' => request()->contact_facebook,
            'contact_instagram' => '',
            'contact_twitter' => '',
            'contact_homepage' => request()->contact_homepage
        ]);

        if (request()->hasFile('file')) {
            $filename =
                'picture-' .
                $user->id .
                '.' .
                request()
                    ->file('file')
                    ->getClientOriginalExtension();

            $filename = Image::storeImageFile(request()->file('file'), $filename);

            $user->images()->delete();
            $user->images()->create(['filename' => $filename]);
        }

        return redirect()
            ->route(request()->has('redirect') ? request()->redirect : 'company.index')
            ->with('info', trans('company.edit.info'));
    }
}
