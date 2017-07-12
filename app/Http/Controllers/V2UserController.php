<?php

namespace App\Http\Controllers;

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

    public function editExperiment()
    {
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
                ->push(component('Form')->with('fields', collect()
                    ->push(component('Title')
                        ->is('small')
                        ->is('blue')
                        ->with('title', 'Profiilipilt')
                    )
                    ->push('<div style="border-radius: 4px; opacity: 0.2; height: 10rem; border: 2px dashed black; font-family: Sailec; display: flex; align-items: center; justify-content: center;">Kasutajapildi lisamine</div>')
                    ->push(component('Title')
                        ->is('small')
                        ->is('blue')
                        ->with('title', 'Kasutaja andmed')
                    )
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'Kasutajanimi')
                    )
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'E-mail')
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', 'Uus parool')
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', 'Korda parooli')
                    )
                    ->push(component('Title')
                        ->is('small')
                        ->is('blue')
                        ->with('title', 'Üldinfo')
                    )
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'Sinu nimi')
                    )
                    ->push(component('FormCheckbox')
                        ->with('title', 'Ei soovi avalikustada oma nime')
                    )
                    ->push(component('Title')
                        ->is('small')
                        ->is('blue')
                        ->with('title', 'E-posti teavitused')
                    )
                    ->push(component('FormCheckbox')
                        ->with('title', 'Teavita mind, kui keegi on saatnud mulle sõnumi')
                    )
                    ->push(component('Title')
                        ->is('small')
                        ->is('blue')
                        ->with('title', 'Kontaktandmed')
                    )
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'Facebooki link')
                    )
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'Instagrami link')
                    )
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'Twitteri link')
                    )
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'Kodulehekülje link')
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->with('disabled', true)
                        ->with('title', 'Uuenda profiili')
                    )
                ))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function destinationsExperiment()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

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
                ->push(component('Form')->with('fields', collect()
                    ->push(component('Title')
                        ->is('small')
                        ->is('blue')
                        ->with('title', 'Ma olen käinud')
                    )
                    ->push(component('FormSelectMultiple')
                        ->with('options', $destinations)
                        ->with('value', $destinations->shuffle()->take(rand(1,30))->pluck('id'))
                    )
                    ->push(component('Title')
                        ->is('small')
                        ->is('blue')
                        ->with('title', 'Ma tahan minna')
                    )
                    ->push(component('FormSelectMultiple')
                        ->with('options', $destinations)
                        ->with('value', $destinations->shuffle()->take(rand(1,30))->pluck('id'))
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->with('disabled', true)
                        ->with('title', 'Lisa')
                    )
                ))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }
}
