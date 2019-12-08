<?php

namespace App\Http\Controllers;

//use Illuminate\Support\Facades\Hash;
use Hash;
use App\User;
use App\Image;
use Carbon\Carbon;

class CompanyController extends Controller
{
    public function create()
    {
        $loggedUser = request()->user();

        return layout('Offer')
            ->with('title', 'Offer')
            ->with('color', 'blue')
            ->with('header', region('OfferHeader'))
            ->with(
                'content',
                collect()->push(
                    component('Title')
                        ->is('large')
                        ->is('white')
                        ->is('center')
                        ->with('title', trans('company.create.title'))
                )
            )
            ->with(
                'bottom',
                collect()->push(
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
                                    component('FormTextfield')
                                        ->with('title', trans('company.edit.instagram.title'))
                                        ->with('name', 'contact_instagram')
                                        ->with('value', old('contact_instagram'))
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
            ->with('footer', region('FooterLight', ''))
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
            'contact_twitter' => 'url',
            'contact_instagram' => 'url',
            'contact_homepage' => 'url',
            'file' => "image|max:$maxfilesize"
        ];

        $this->validate(request(), $rules);

        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' =>  Hash::make(request()->password),
            'real_name' => request()->company_name,
            'real_name_show' => 1,
            'notify_message' => 0,
            'notify_follow' => 0,
            'description' => request()->description,
            'contact_facebook' => request()->contact_facebook,
            'contact_instagram' => request()->contact_instagram,
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
            ->route('user.show', [$user])
            ->with('info', trans('user.update.info'));
    }
}
