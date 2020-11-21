<?php

namespace App\Http\Controllers;

use App\Company;
use Hash;
use Carbon\Carbon;

use App\User;
use App\Image;
use App\Offer;

class CompanyController extends Controller
{
    public function profile($slug)
    {
        $company = Company::whereSlug($slug);
        if (!$company) {
            abort(404);
        }

        return view('pages.company.profile');
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
                                component('Form2')
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
                                component('Form2')
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
