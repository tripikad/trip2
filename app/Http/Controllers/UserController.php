<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\Image;
use App\Destination;
use App\NewsletterType;

class UserController extends Controller
{
    public function show($id)
    {
        $types = ['forum', 'travelmate', 'buysell'];

        $user = User::findOrFail($id);

        if ($user->company) {
            return redirect()->route('company.profile.public', ['slug' => $user->company->slug]);
        }

        $loggedUser = request()->user();

        $photos = $user
            ->contents()
            ->whereType('photo')
            ->whereStatus(1)
            ->take(9)
            ->latest()
            ->get();

        $comments = $user
            ->comments()
            ->with('user', 'content', 'content.user', 'content.comments', 'content.destinations', 'flags')
            ->whereStatus(1)
            ->whereHas('content', function ($query) use ($types) {
                $query->whereIn('type', $types);
            })
            ->latest()
            ->take(24)
            ->get();

        return layout('Two')
            ->with('title', $user->vars()->name())
            ->with('head_title', $user->vars()->name())
            ->with(
                'head_description',
                trans("user.rank.$user->rank") .
                    trans('user.show.about.joined', [
                        'created_at' => $user->vars()->created_at_relative
                    ])
            )
            ->with('head_image', Image::getSocial())

            ->with('color', 'cyan')

            ->with('header', region('UserHeader', $user))

            ->with('top', collect()->pushWhen($photos->count(), region('PhotoSection', $photos, $loggedUser)))

            ->with(
                'content',
                collect()
                    ->pushWhen(
                        $comments->count(),
                        component('BlockTitle')
                            ->is('cyan')
                            ->with('title', trans('user.activity.comments.title'))
                    )
                    ->merge(
                        $comments->flatMap(function ($comment) {
                            return collect()
                                ->push(
                                    component('Meta')->with(
                                        'items',
                                        collect()
                                            ->push(
                                                component('MetaLink')->with(
                                                    'title',
                                                    trans('user.activity.comments.row.1')
                                                )
                                            )
                                            ->push(
                                                component('MetaLink')
                                                    ->is('cyan')
                                                    ->with('title', trans('user.activity.comments.row.2'))
                                                    ->with(
                                                        'route',
                                                        route($comment->content->type . '.show', [
                                                            $comment->content->slug
                                                        ]) .
                                                            '#comment-' .
                                                            $comment->id
                                                    )
                                            )
                                            ->push(
                                                component('MetaLink')->with(
                                                    'title',
                                                    trans('user.activity.comments.row.3')
                                                )
                                            )
                                            ->push(
                                                component('MetaLink')
                                                    ->is('cyan')
                                                    ->with('title', $comment->content->vars()->title)
                                                    ->with('route', route('forum.show', [$comment->content->slug]))
                                            )
                                    )
                                )
                                ->push(region('Comment', $comment));
                        })
                    )
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $weekly_newsletter = NewsletterType::where('type', 'weekly')
            ->with('user_subscriptions')
            ->where('active', 1)
            ->first();

        if ($weekly_newsletter) {
            $weekly_subscription = $weekly_newsletter->user_subscriptions->first();

            if ($weekly_subscription && $weekly_subscription->active) {
                $weekly_subscription = 1;
            } else {
                $weekly_subscription = 0;
            }
        }

        return layout('One')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with(
                'top',
                collect()->push(
                    component('Title')
                        ->is('center')
                        ->is('large')
                        ->with('title', 'Muuda profiili')
                )
            )

            ->with(
                'content',
                collect()->push(
                    component('Form')
                        ->with('route', route('user.update', [$user]))
                        ->with('method', 'PUT')
                        ->with('files', true)
                        ->with(
                            'fields',
                            collect()
                                ->push(
                                    component('Title')
                                        ->is('small')
                                        ->is('blue')
                                        ->with('title', trans('user.image.title'))
                                )
                                ->push(
                                    component('FormUpload')
                                        ->with('title', trans('user.image.title'))
                                        ->with('name', 'file')
                                )
                                ->push(
                                    component('Title')
                                        ->is('small')
                                        ->is('blue')
                                        ->with('title', trans('user.edit.account.title'))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->is('large')
                                        ->with('title', trans('user.edit.field.name.title'))
                                        ->with('name', 'name')
                                        ->with('value', old('name', $user->name))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->is('large')
                                        ->with('title', trans('user.edit.field.email.title'))
                                        ->with('name', 'email')
                                        ->with('value', old('email', $user->email))
                                )
                                ->push(
                                    component('FormPassword')
                                        ->is('large')
                                        ->with('title', trans('user.edit.field.password.title'))
                                        ->with('name', 'password')
                                        ->with('value', '')
                                )
                                ->push(
                                    component('FormPassword')
                                        ->is('large')
                                        ->with('title', trans('user.edit.field.password_confirmation.title'))
                                        ->with('name', 'password_confirmation')
                                        ->with('value', '')
                                )
                                ->push(
                                    component('Title')
                                        ->is('small')
                                        ->is('blue')
                                        ->with('title', trans('user.edit.general.title'))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->is('large')
                                        ->with('title', trans('user.edit.field.real.name.title'))
                                        ->with('name', 'real_name')
                                        ->with('value', old('real_name', $user->real_name))
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('title', trans('user.edit.field.real.name.show.title'))
                                        ->with('name', 'real_name_show')
                                        ->with('value', !$user->real_name_show)
                                )
                                ->push(
                                    component('FormTextarea')
                                        ->with('rows', 4)
                                        ->with('title', trans('user.edit.field.description.label'))
                                        ->with('placeholder', trans('user.edit.field.description.title'))
                                        ->with('name', 'description')
                                        ->with('value', old('description', $user->description))
                                )
                                ->push(
                                    component('Title')
                                        ->is('small')
                                        ->is('blue')
                                        ->with('title', trans('user.edit.notify.title'))
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('title', trans('user.edit.field.notify_message.title'))
                                        ->with('name', 'notify_message')
                                        ->with('value', old('notify_message', $user->notify_message))
                                )
                                ->push(
                                    component('FormCheckbox')
                                        ->with('title', trans('user.edit.field.notify_follow.title'))
                                        ->with('name', 'notify_follow')
                                        ->with('value', old('notify_follow', $user->notify_follow))
                                )
                                ->pushWhen(
                                    $weekly_newsletter,
                                    component('FormCheckbox')
                                        ->with('title', trans('newsletter.subscribe.field.newsletter_notify'))
                                        ->with('name', 'newsletter_subscribe')
                                        ->with('value', old('newsletter_subscribe', $weekly_subscription ?? 0))
                                )
                                ->push(
                                    component('Title')
                                        ->is('small')
                                        ->is('blue')
                                        ->with('title', trans('user.edit.contact.title'))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('title', trans('user.edit.field.contact_facebook.title'))
                                        ->with('name', 'contact_facebook')
                                        ->with('value', old('contact_facebook', $user->contact_facebook))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('title', trans('user.edit.field.contact_instagram.title'))
                                        ->with('name', 'contact_instagram')
                                        ->with('value', old('contact_instagram', $user->contact_instagram))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('title', trans('user.edit.field.contact_twitter.title'))
                                        ->with('name', 'contact_twitter')
                                        ->with('value', old('contact_twitter', $user->contact_twitter))
                                )
                                ->push(
                                    component('FormTextfield')
                                        ->with('title', trans('user.edit.field.contact_homepage.title'))
                                        ->with('name', 'contact_homepage')
                                        ->with('value', old('contact_homepage', $user->contact_homepage))
                                )
                                ->push(
                                    component('FormButton')
                                        ->is('wide')
                                        ->is('large')
                                        ->with('title', trans('user.edit.submit'))
                                )
                        )
                )
            )

            ->with('footer', region('FooterLight'))

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
            'contact_twitter' => 'url',
            'contact_instagram' => 'url',
            'contact_homepage' => 'url',
            'file' => "image|max:$maxfilesize"
        ];

        $this->validate(request(), $rules);

        $weekly_newsletter = NewsletterType::where('type', 'weekly')
            ->where('active', 1)
            ->first();

        // @todo Avoid direct controller method call

        if ($weekly_newsletter) {
            (new NewsletterController())->subscribe(request(), $weekly_newsletter->id);
        }

        $user->update([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
            'real_name' => request()->real_name,
            'real_name_show' => request()->real_name_show ? 0 : 1,
            'notify_message' => request()->notify_message ? 1 : 0,
            'notify_follow' => request()->notify_follow ? 1 : 0,
            'description' => request()->description,
            'contact_facebook' => request()->contact_facebook,
            'contact_instagram' => request()->contact_instagram,
            'contact_twitter' => request()->contact_twitter,
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
            ->route('user.show', [$user])
            ->with('info', trans('user.update.info'));
    }

    public function destinationsEdit($id)
    {
        $user = User::findorFail($id);
        $destinations = Destination::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $havebeen = $user
            ->destinationHaveBeen()
            ->filter(function ($flag) use ($destinations) {
                return $destinations->contains('id', $flag->flaggable_id);
            })
            ->pluck('flaggable_id');

        $wantstogo = $user
            ->destinationWantsToGo()
            ->filter(function ($flag) use ($destinations) {
                return $destinations->contains('id', $flag->flaggable_id);
            })
            ->pluck('flaggable_id');

        return layout('One')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with(
                'top',
                collect()->push(
                    component('Title')
                        ->is('center')
                        ->is('large')
                        ->with('title', 'Minu sihtkohad')
                )
            )
            ->with(
                'content',
                collect()->push(
                    component('Form')
                        ->with('route', route('user.destinations.store', [$user]))
                        ->with('method', 'PUT')
                        ->with(
                            'fields',
                            collect()
                                ->push(
                                    component('Title')
                                        ->is('small')
                                        ->is('blue')
                                        ->with('title', 'Ma olen käinud')
                                )
                                ->push(
                                    component('FormSelectMultiple')
                                        ->with('options', $destinations)
                                        ->with('name', 'havebeen')
                                        ->with('value', $havebeen)
                                )
                                ->push(
                                    component('Title')
                                        ->is('small')
                                        ->is('blue')
                                        ->with('title', 'Ma tahan minna')
                                )
                                ->push(
                                    component('FormSelectMultiple')
                                        ->with('options', $destinations)
                                        ->with('name', 'wantstogo')
                                        ->with('value', $wantstogo)
                                )
                                ->push(
                                    component('FormButton')
                                        ->is('wide')
                                        ->with('title', 'Lisa')
                                )
                        )
                )
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function destinationsStore($id)
    {
        $rules = [
            'havebeen.*' => 'exists:destinations,id',
            'wantstogo.*' => 'exists:destinations,id'
        ];

        $this->validate(request(), $rules);

        $user = User::findorFail($id);

        // Updating havebeen

        $user
            ->flags()
            ->where('flaggable_type', 'App\Destination')
            ->where('flag_type', 'havebeen')
            ->delete();

        collect(request()->havebeen)->each(function ($id) use ($user) {
            $user->flags()->create([
                'flaggable_type' => 'App\Destination',
                'flaggable_id' => $id,
                'flag_type' => 'havebeen'
            ]);
        });

        // Updating wantstogo

        $user
            ->flags()
            ->where('flaggable_type', 'App\Destination')
            ->where('flag_type', 'wantstogo')
            ->delete();

        collect(request()->wantstogo)->each(function ($id) use ($user) {
            $user->flags()->create([
                'flaggable_type' => 'App\Destination',
                'flaggable_id' => $id,
                'flag_type' => 'wantstogo'
            ]);
        });

        return redirect()
            ->route('user.show', [$user])
            ->with('info', trans('user.update.info'));
    }
}
