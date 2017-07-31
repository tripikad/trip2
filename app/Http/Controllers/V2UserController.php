<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\Image;
use App\Content;
use App\Destination;

class V2UserController extends Controller
{
    public function show($id)
    {
        $types = ['forum', 'travelmate', 'buysell'];

        $user = User::findOrFail($id);

        $loggedUser = request()->user();

        $photos = $user
            ->contents()
            ->whereType('photo')
            ->whereStatus(1)
            ->take(9)
            ->latest()
            ->get();

        $comments = $user->comments()
            ->with(
                'user',
                'content',
                'content.user',
                'content.comments',
                'content.destinations',
                'flags'
            )
            ->whereStatus(1)
            ->whereHas('content', function ($query) use ($types) {
                $query->whereIn('type', $types);
            })
            ->latest()
            ->take(24)
            ->get();

        return layout('1col')

            ->with('title', $user->vars()->name())
            ->with('head_title', $user->vars()->name())
            ->with(
                'head_description',
                trans("user.rank.$user->rank")
                .trans('user.show.about.joined', [
                    'created_at' => $user->vars()->created_at_relative,
                ])
            )
            ->with('head_image', Image::getSocial())
            ->with('background', component('BackgroundMap'))

            ->with('color', 'cyan')

            ->with('header', region('UserHeader', $user))

            ->with('top',
                $photos->count() || ($loggedUser && $user->id == $loggedUser->id)
                ? region(
                    'PhotoRow',
                    $photos->count() ? $photos : collect(),
                    collect()
                        ->pushWhen(
                            $photos->count(),
                            component('Button')
                                ->is('transparent')
                                ->with('title', trans('content.photo.more'))
                                ->with('route', route(
                                    'photo.user',
                                    [$user]
                                ))
                        )
                        ->pushWhen(
                            $loggedUser && $user->id == $loggedUser->id,
                            component('Button')
                                ->is($photos->count() ? 'transparent' : 'cyan')
                                ->with('title', trans('content.photo.create.title'))
                                ->with('route', route('photo.create'))
                        )
                )
                : ''
            )

            ->with('content', collect()
                ->pushWhen($comments->count(), component('BlockTitle')
                    ->is('cyan')
                    ->with('title', trans('user.activity.comments.title'))
                )
                ->merge($comments->flatMap(function ($comment) {
                    return collect()
                        ->push(component('Meta')->with('items', collect()
                            ->push(component('MetaLink')
                                ->with('title', trans('user.activity.comments.row.1'))
                            )
                            ->push(component('MetaLink')
                                ->is('cyan')
                                ->with('title', trans('user.activity.comments.row.2'))
                                ->with('route', route($comment->content->type.'.show', [
                                   $comment->content->slug,
                               ]).'#comment-'.$comment->id)
                            )
                            ->push(component('MetaLink')
                                ->with('title', trans('user.activity.comments.row.3'))
                            )
                            ->push(component('MetaLink')
                                ->is('cyan')
                                ->with('title', $comment->content->vars()->title)
                                 ->with('route', route('forum.show', [
                                    $comment->content->slug,
                                ]))
                            )
                        ))
                        ->push(region('Comment', $comment));
                }))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function edit2($id)
    {
        $user = User::findOrFail($id);

        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', 'Muuda profiili')
                )
            )

            ->with('content', collect()
                ->push(component('Form')
                    ->with('route', route('user.update2', [$user]))
                    ->with('method', 'PUT')
                    ->with('fields', collect()
                        ->push(component('Title')
                            ->is('small')
                            ->is('blue')
                            ->with('title', 'Profiilipilt')
                        )
                        ->push('<div style="border-radius: 4px; opacity: 0.2; height: 10rem; border: 2px dashed black; font-family: Sailec; display: flex; align-items: center; justify-content: center;">Kasutajapildi lisamine (komponent)</div>')
                        ->push(component('Title')
                            ->is('small')
                            ->is('blue')
                            ->with('title', 'Kasutaja andmed')
                        )
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', 'Kasutajanimi')
                            ->with('name', 'name')
                            ->with('value', old('name', $user->name))
                        )
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', 'E-mail')
                            ->with('name', 'email')
                            ->with('value', old('email', $user->email))
                        )
                        ->push(component('FormPassword')
                            ->is('large')
                            ->with('title', 'Uus parool')
                            ->with('name', 'password')
                            ->with('value', '')
                        )
                        ->push(component('FormPassword')
                            ->is('large')
                            ->with('title', 'Korda parooli')
                            ->with('name', 'password_confirmation')
                            ->with('value', '')
                        )
                        ->push(component('Title')
                            ->is('small')
                            ->is('blue')
                            ->with('title', 'Üldinfo')
                        )
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', 'Sinu nimi')
                            ->with('name', 'real_name')
                            ->with('value', old('real_name', $user->real_name))
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', 'Ei soovi avalikustada oma nime')
                            ->with('name', 'real_name_show')
                            ->with('value', old('real_name_show', !$user->real_name_show))
                        )
                        ->push(component('FormTextarea')
                            ->with('rows', 4)
                            ->with('title', 'Lühikirjeldus')
                            ->with('placeholder', 'Kirjelda tripikatele ennast ja oma reisikogemusi...')
                            ->with('name', 'description')
                            ->with('value', old('description', $user->description))
                        )
                        ->push(component('Title')
                            ->is('small')
                            ->is('blue')
                            ->with('title', 'E-posti teavitused')
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', 'Teavita mind, kui keegi on saatnud mulle sõnumi')
                            ->with('name', 'notify_message')
                            ->with('value', old('notify_message', $user->notify_message))
                        )
                        ->push(component('Title')
                            ->is('small')
                            ->is('blue')
                            ->with('title', 'Kontaktandmed')
                        )
                        ->push(component('FormTextfield')
                            ->with('title', 'Facebooki link')
                            ->with('name', 'contact_facebook')
                            ->with('value', old('contact_facebook', $user->contact_facebook))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', 'Instagrami link')
                            ->with('name', 'contact_instagram')
                            ->with('value', old('contact_instagram', $user->contact_instagram))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', 'Twitteri link')
                            ->with('name', 'contact_twitter')
                            ->with('value', old('contact_twitter', $user->contact_twitter))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', 'Kodulehekülje link')
                            ->with('name', 'contact_homepage')
                            ->with('value', old('contact_homepage', $user->contact_homepage))
                        )
                        ->push(component('FormButton')
                            ->is('wide')
                            ->is('large')
                            ->with('title', 'Uuenda profiili')
                        )
                ))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    
    public function update2($id)
    {
        $user = User::findorFail($id);
        $rules = [
            'name' => 'required|unique:users,name,'.$user->id,
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'sometimes|confirmed|min:6',
            'password_confirmation' => 'required_with:password|same:password',
            'description' => 'min:2',
            'contact_facebook' => 'url',
            'contact_twitter' => 'url',
            'contact_instagram' => 'url',
            'contact_homepage' => 'url'
        ];

        $this->validate(request(), $rules);

        $user->update([
            'name' => request()->name,
            'email' => request()->email,
            'password' => Hash::make(request()->password),
            'real_name' => request()->real_name,
            'real_name_show' => request()->dreal_name_show ? 0 : 1,
            'notify_message' => request()->notify_message ? 1 : 0,
            'description' => request()->description,
            'contact_facebook' => request()->contact_facebook,
            'contact_instagram' => request()->contact_instagram,
            'contact_twitter' => request()->contact_twitter,
            'contact_homepage' => request()->contact_homepage
        ]);

        return redirect()
            ->route('user.show', [$user])
            ->with('info', trans('user.update.info'));
    }

    public function destinationsEdit2($id)
    {
        $user = User::findorFail($id);
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        $havebeen = $user
            ->destinationHaveBeen()
            ->filter(function($flag) use ($destinations) {
                return $destinations->contains('id', $flag->flaggable_id);
            })
            ->pluck('flaggable_id');

        $wantstogo = $user
            ->destinationWantsToGo()
            ->filter(function($flag) use ($destinations) {
                return $destinations->contains('id', $flag->flaggable_id);
            })
            ->pluck('flaggable_id');

        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', 'Minu sihtkohad')
                )
            )
            ->with('content', collect()
                ->push(component('Form')
                    ->with('route', route('user.destinations.store2', [$user]))
                    ->with('method', 'PUT')
                    ->with('fields', collect()
                        ->push(component('Title')
                            ->is('small')
                            ->is('blue')
                            ->with('title', 'Ma olen käinud')
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('options', $destinations)
                            ->with('name', 'havebeen')
                            ->with('value', $havebeen)
                        )
                        ->push(component('Title')
                            ->is('small')
                            ->is('blue')
                            ->with('title', 'Ma tahan minna')
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('options', $destinations)
                            ->with('name', 'wantstogo')
                            ->with('value', $wantstogo)
                        )
                        ->push(component('FormButton')
                            ->is('wide')
                            ->with('title', 'Lisa')
                        )
                ))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function destinationsStore2($id)
    {
        
        $rules = [
            'havebeen.*' => 'exists:destinations,id',
            'wantstogo.*' => 'exists:destinations,id'
        ];

        $this->validate(request(), $rules);

        $user = User::findorFail($id);

        // Updating havebeen

        $user->flags()
            ->where('flaggable_type', 'App\Destination')
            ->where('flag_type', 'havebeen')
            ->delete();
        
        collect(request()->havebeen)
            ->each(function($id) use ($user) {
                $user->flags()->create([
                    'flaggable_type' => 'App\Destination',
                    'flaggable_id' => $id,
                    'flag_type' => 'havebeen',
                ]);
            });
            
        // Updating wantstogo

        $user->flags()
            ->where('flaggable_type', 'App\Destination')
            ->where('flag_type', 'wantstogo')
            ->delete();
        
        collect(request()->wantstogo)
            ->each(function($id) use ($user) {
                $user->flags()->create([
                    'flaggable_type' => 'App\Destination',
                    'flaggable_id' => $id,
                    'flag_type' => 'wantstogo',
                ]);
            });

        return redirect()
            ->route('user.show', [$user])
            ->with('info', trans('user.update.info'));
    }
}
