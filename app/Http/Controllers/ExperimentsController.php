<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;
use App\User;
use DB;
use Carbon\Carbon;

class ExperimentsController extends Controller
{

    
    public function trip20Index()
    {
        $pictureMap = [
            1 => 'https://web.archive.org/web/20070609230611if_/http://trip.ee/files/pictures/picture-1.jpg',
            2 => 'https://web.archive.org/web/20070609212559if_/http://www.trip.ee/files/pictures/picture-2.jpg',
            7 => 'https://web.archive.org/web/20070218154753if_/http://trip.ee:80/files/pictures/picture-7.jpg',
            23 => 'http://www.bluemoon.ee/~ahti/nepal/photos/ahti-holi-500x338.jpg',
            28 => 'https://www.photo.net/avatar/785095',
            // 55 => 'https: //web.archive.org/web/20070609220650if_/http://www.trip.ee/files/pictures/picture-55.jpg'
        ];

        $friendMap = [
            4 => 'koolikaaslane',
            10 => 'testkonto',
            12 => 'koolikaaslane',
            13 => 'koolikaaslane',
            15 => 'koolikaaslane',
            16 => 'koolikaaslane',
            17 => 'sugulane',
            19 => 'sugulane',
            63 => 'special someone',
            65 => 'sugulane',
            79 => 'testkonto',
        ];

        $users = User::orderBy('created_at', 'asc')
            ->take(100)
            ->skip(0)
            ->get();

        $users2 = DB::connection('trip')
            ->table('users')
            ->where('uid','>',0)
            //->take(227)
            ->take(83)
            ->orderBy('uid','asc')
            ->get()
            //->filter(function ($user) { return $user->picture; })
            ->map(function($user) use ($pictureMap, $friendMap) {
                $u1 = explode('@', $user->mail)[0];
                $u2 = explode('.', explode('@', $user->mail)[1])[0];
                $user->mail = json_encode([$u1,$u2]);
                $limit = Carbon::create(2015, 1, 1, 0, 0, 0)->timestamp;
                $user->created = $user->created > 654732000 ? Carbon::createFromTimestamp($user->created)->format('j. M Y') : '-';
                $user->access = $user->access > 654732000 && $user->access < $limit ? Carbon::createFromTimestamp($user->access)->format('j. M Y') : '-';
                $user->login = $user->login > 654732000 && $user->access < $limit ? Carbon::createFromTimestamp($user->login)->format('j. M Y') : '-';
                $user->image = null;
                // if ($user->data) {
                //     $user->data = unserialize($user->data);
                //     $user->homepage = array_key_exists('homepage', $user->data) ? 'ho' : null;
                // }
                $user->archivepicture = null;
                if ($user->picture) {
                    $user->archivepicture = 'https://web.archive.org/web/*/trip.ee/'.$user->picture;
                }
                $newUser = User::find($user->uid);
                if ($newUser && $newUser->images->first()) {
                   $user->image = 'https:/trip.ee/images/small_square/' . $newUser->images->first()['filename'];
                }
                if (array_key_exists($user->uid, $pictureMap)) {
                    $user->image = $pictureMap[$user->uid];  
                };
                if ($user->uid == 1) {
                    $user->name = 'kika';
                    $user->access = '-';
                    $user->login = '-';
                }
                if ($user->uid == 12) {
                    $user->name = 'Mark';
                    $user->access = '-';
                    $user->login = '-';
                    $user->mail = $user->init;
                    $user->image = null;
                }
                if ($user->uid == 27) {
                    $user->created = '-';
                }
                if (array_key_exists($user->uid, $friendMap)) {
                    $user->name = $user->name . ' ('.$friendMap[$user->uid].')';
                }
                $user->content = DB::connection('trip')
                    ->table('node')
                    ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
                    ->select('node.*')
                    ->where('node.uid', '=', $user->uid == 1 ? 12 : $user->uid)
                    ->orderBy('node.nid')
                    ->take(5)
                    ->get()
                    ->map(function ($link) {
                        $link->created = Carbon::createFromTimestamp($link->created)->format('j. M Y');
                        $link->changed = Carbon::createFromTimestamp($link->changed)->format('j. M Y');
                        $link->archivelink = 'https://web.archive.org/web/*/trip.ee/node/' . $link->nid;
                        return $link;
                    });
                if ($user->uid == 12) {
                    $user->content = [];
                }
                return $user;
            });

        //return $users2;

        return layout('Two')
            ->with('content', $users2->map(function ($user) {
                return collect()
                    ->push('<div style="opacity: '. ($user->uid == 6 ? 0.5 : 1).'">')
                    ->push(component('Body')->with('body', format_body(collect()
                        ->push($user->image ? '<img style="display: block; width: 128px;" src=' . $user->image . ' />' : '')
                        ->push('#' . $user->uid . ' '.$user->name . ' ')
                        ->push('Created: ' . $user->created)
                        ->push('Access: ' . $user->access)
                        ->push('Login: ' . $user->login)
                        ->push('Email: ' . $user->mail)
                        ->push('Init email: ' . $user->init)
                        ->push('Signature: ' . $user->signature)
                        ->push('#### Postitused')
                        ->push(collect($user->content)->map(function($c) {
                            return collect(['[' . $c->title . '](' . $c->archivelink . ') ', $c->created,$c->changed,$c->type])->implode(' · ');
                        })->implode("\n"))
                        ->implode("\n")))
                    )
                    ->push('</div>')
                    ->render()
                    ->implode('');
            }))
            ->render();

        return layout('Two')
            ->with('content', $images->map(function ($image) {
                return component('Body')->with('body', format_body(collect()
                    ->push('####' . $image->title . ' ')
                    ->push('<img src=' . $image->imagePreset('medium') . ' />')
                    ->push('Original published at: ' . $image->created_at)
                    ->push('Added to Trip: ' . $image->updated_at)
                    ->implode("\n")));
            }))
            ->render();

        $weblinks = DB::connection('trip')
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->join('weblink', 'weblink.nid', '=', 'node.nid')
            ->select('node.*', 'weblink.*')
            ->where('node.created', '<', Carbon::create(1999, 1, 1, 0, 0, 0)->timestamp)
            ->where('node.type', '=', 'weblink')
            ->take(100)
            ->get()
            ->map(function ($link) {
                $link->created = $link->created < 1 ? Carbon::create(1998, 1, 1, 0, 0, 0)->timestamp : $link->created;               
                return $link;
            })
            ->sortBy('created')
            ->map(function ($link) {
                $link->created = Carbon::createFromTimestamp($link->created)->format('j. M Y');
                $link->changed = Carbon::createFromTimestamp($link->changed)->format('j. M Y');
                $link->archivelink = 'https://web.archive.org/web/*/' . $link->weblink;
                return $link;
            });

            return layout('Two')
                ->with('content', collect()
                    ->push(
                        component('Title')->with('title', 'Reisiartiklid Eesti ajalehtedes 1995-1998')
                    )
                    ->merge($weblinks->map(function($q) {
                        return component('Body')->with('body', format_body(collect()
                            ->push('####' .$q->title.' ')
                            ->push('['.$q->weblink.']('. $q->archivelink .')')
                            ->push('Original published at: '.$q->created)
                            ->push('Added to Trip: '.$q->changed)
                            ->implode("\n")
                        ));
                    }))
                )
                ->render();

    }

    public function index()
    {
        $user = auth()->user();

        return layout('Two')

            ->with('content', collect()

                ->push(component('Title')
                    ->with('title', 'Code')
                )

                ->push(component('Code')
                    ->is('gray')
                    ->with('code', "Hello\nworld")
                )

                ->push(component('Title')
                    ->with('title', 'Small editor')
                )

                ->push(component('EditorSmall')
                    ->with('value', 'Testing it out')
                )

                ->push(component('Title')
                    ->with('title', 'Misc')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Selects')
                    ->with('route', route('experiments.select.index'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Fonts')
                    ->with('route', route('experiments.fonts.index'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Map')
                    ->with('route', route('experiments.map.index'))
                )

                ->push(component('Title')
                    ->with('title', 'Layouts')
                )

                ->push(component('MetaLink')
                    ->with('title', 'One')
                    ->with('route', route('experiments.layouts.one'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Two')
                    ->with('route', route('experiments.layouts.two'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Grid')
                    ->with('route', route('experiments.layouts.grid'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Frontpage')
                    ->with('route', route('experiments.layouts.frontpage'))
                )

            )

            ->render();
    }

    public function selectIndex()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        return layout('Two')

            ->with('content', collect()

                ->push(component('Form')
                    ->with('route', route('experiments.select.create'))
                    ->with('fields', collect()
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations1')
                            ->with('options', $destinations)
                            ->with('value', [1])
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations2')
                            ->with('options', $destinations)
                            ->with('value', [2, 3])
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormSelect')
                            ->with('name', 'destination1')
                            ->with('options', $destinations)
                            ->with('value', 4)
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormSelect')
                            ->with('name', 'destination2')
                            ->with('options', $destinations)
                            ->with('value', 5)
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.edit.submit.title'))
                        )
                    )
                )
            )

            ->render();
    }

    public function selectCreate()
    {
        dump(request()->all());
    }

    public function mapIndex()
    {
        return layout('Two')

            ->with('content', collect()
                ->push(component('Dotmap')
                    ->with('dots', config('dots'))
                )
            )

        ->render();
    }

    public function fontsIndex()
    {
        return layout('Two')

            ->with('content', collect()
                ->push(component('ExperimentalFont'))
            )

            ->render();
    }
}
