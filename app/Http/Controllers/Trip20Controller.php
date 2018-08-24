<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use App\Content;
use App\Destination;
use App\User;
use DB;
use Carbon\Carbon;


class Trip20Controller extends Controller
{

    public function card($items)
    {
        $items = $items->map(function ($value, $key) {
            $value = $value ?? ' - ';
            if ($key == 'Title') {
                return '#### ' . $value;
            }
            if ($key == 'Subject') {
                return '**' . $value . '**';
            }
            if ($key == 'Body') {
                return '<br>' . $value;
            }
            return $key . ': ' . $value;
        });

        return component('Body')
            ->with('body', format_body($items->implode("\n")));
    }

    public function pager($route)
    {
        $steps = [0, 100, 200, 300, 400, 500, 600, 700, 800, 900];
        return component('Grid')
            ->with('inline', true)
            ->with('cols', count($steps))
            ->with('gap', 2)
            ->with('items', collect($steps)
                ->map(function($from) use ($route) {
                    return component('Title')
                        ->with('title', ($from + 1) . '-' . ($from + 100))
                        ->is('smallest')
                        ->with('route', route($route, ['from' => $from]));
                })
            );
    }

    public function formatAuthor($item)
    {
        return collect()
            ->push($item->name ? $item->name : ($item->author_name ? $item->author_name : '-'))
            ->push($item->mail ? $item->mail : ($item->author_email ? $item->author_email : '-'))
            ->implode(' / ');
    }

    public function formatLinks($item)
    {
        return collect()
            ->push('<a href="'.$item->link.'">trip.ee</a>')
            ->push('<a href="' . $item->archivelink . '">archive.org</a>')
            ->implode(' / ');
    }

    public function links() {
        $links = collect()
            ->put('trip20.about', 'Ajalugu')
            ->put('trip20.users', 'Kasutajad')
            ->put('trip20.forums', 'Foorum')
            ->put('trip20.links', 'Lingid')
            ->put('trip20.images', 'Pildid')
            ->map(function($title, $route) {
                return component('Title')
                    ->is('gray')
                    ->is('small')
                    ->with('title', $title)
                    ->with('route', route($route))
                ;
            });
        
        return component('Grid')
            ->with('items', collect()
                ->push(component('Title')->is('green')->with('title', 'Trip20'))
                ->merge($links)
            )
            ->with('gap', 2)
            ->with('inline', true)
            ->with('cols', $links->count() + 1)
        ;
    }

    public function aboutIndex()
    {
        $md = <<<MD

> Eesti vanim ja suurim reisiportaal Trip.ee nägi ilmavalgust 1998. aastal, kui kaks reisihuvilisest sõpra Kristjan ja Tom otsustasid püsti panna lehe, kus reisisellid saavad kogemusi vahetada.

![](photos/trip20_829.jpg)

Tartu Ülikooli viimastel kursustel, kus õpihimu raugema ning kodumaised rabamatkad ammenduma  ammenduma hakkasid, otsustasid klassivennad Kristjan Jansen ja Toomas Toots Euroopasse sõita ja kohe müstilisse Portugali välja.

![](photos/trip20_viisa.jpg)

Üks keerukaimaid asju reisimise juures oli Schengeni viisa jaoks küllakutse saamine, tollal lõppes eestlase jaoks viisavabadus Tšehhi-Saksamaa ja Ungari-Saksamaa piiri ääres. Enamus tutvusringkonnast lahends olukorra Taize kloostri  poolfiktiivse külastusega, koos vagade tõsiusklikega sõideti Pransusmaale ja sealt "hüpati ära", Schengeni viisa taskus. Teine, kindlam, kuid kallim oli astuda **rahvusvahelise autoklubi** liikmeks, kes siis küllakutse vormistas.

Järgmine küsimus oli transport - odavlende poldud veel leiutatud, **Interaili** üleeuroopaline rongipileti tudengile valus laks - enamus kevadistel Toomemäel sumisejatest tudengitest kallas Tõmmu Hiiu Coca-Cola pudelisse ja läks Riia maanteele hääletama, silme ees Praha Karli sild ja kohatult odav õlu.

![](photos/trip20_tomkika.jpg)

Kristjan ja Toomas polnud Pirogovi-mehed ning Liivimaa Kroonikas ning Tartu Ölletehases teenitud säästud läksid autoklubi ning Interraili pileti peale ning 1997. suvel võis poolpõlenud Tartu vaksalis Balti Ekspressi peale istuda.

![](photos/trip20_830.jpg)

Portugali jõudsid küll ainult Toomas ja tema kaaslanna Mariliis, Kristjan pöördus Barcelonas palavikku jäädes tagasi, kuid reisipisik oli kamraade nüüdseks tugevalt nakatanud. Sarnase reisi tegid sõbrad ka 1998. aastal -- Kristjan jõudis isegi seljakotirändureid ja liisunud veini täis Itaalia-Kreeka praamile -- ning siis 1998. aasta suve lõpul tundus et kõike seda tahaks jagada. Kuid kus seda teha? Eestis polnud midagi LP Thorn Three,Virtualtouristi ega Sleepinginairports sarnast ning sotsiaalvõrke polnud veel leiutatud.

![](photos/trip20_kavandid.jpg)

Aeg oli teha esimene eestikeelne reisifoorum, Trip. Esimene lehe versioon käivitus septembris 1998, tänaseks obskuursusesse vajunud Lotus Notesi platvormil ning aadressil **trip.magnum.ee**, Toomase tollase  töökoha, Magnum Medicali alamdomeenina. .ee domeeni saamine polnud tollal lihtne, neid väljastati vaid ettevõtetele ning firmal tohtis olla vaid üks domeen. Toomase firma i-Süsteem'il oli omanimeline domeen juba võetud ja nii oli Trip lühikest aega ka **trip.nu** aadressil. Umbes 2000. aastal sai **trip.ee** lõpuks oma domeeni.

Peale erinevaid sisuhaldussüsteemide katsetusi kirjutas Kristjan Tripi ümber http://drupal.org platvormile, kus see püsis järgmine 17. aastat. Praguseks on Trip.ee liikunud omakirjutatud platvormile.

> Suurema hoo sai Trip.ee sisse 2000-ndate algul, kui värskelt Eesti turule sisenenud Lufthansa pakkus supersoodsaid pileteid lendudele Lõuna-Ameerikasse. Ühtäkki avastasid paljud, et Tšiilisse või Kolumbiasse reisimisest pole pääsu. Kuna infot nappis, tundus sel ajal iga infokild kulla hinnaga.

> 2004\. aastal hakkas Trip.ee reisifoorum samm-sammult võtma sellist ilmet, nagu seda täna võib näha. Samal ajal said hoo sisse paketireisid Egiptusesse ja foorumisse tekkisid esimesed asukohaeksperdid. Sellesse aega jäävad ka mitmed tulised verbaalsed võitlused.
MD;
        return layout('Two')
            ->with('content', collect()
                ->push($this->links())
                ->push('<br>')
                ->push(component('Body')->with('body', format_body($md)))
            )
            ->render()
        ;
    }

    public function forumsIndex()
    {
        $commentIds = collect();

        $nodes = DB::connection('trip')
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->join('users', 'users.uid', '=', 'node.uid')
            ->join('trip_forum', 'trip_forum.nid', '=', 'node.nid')
            ->where('node.type', '=', 'trip_forum')
            ->take(100)
            ->skip(request()->get('from', 0))
            ->get()
            ->sortBy('created')
            ->map(function ($node) use (&$commentIds) {
                $commentIds->push($node->nid);
                return $node;
            });

        $comments = DB::connection('trip')
            ->table('comments')
            ->whereIn('comments.nid', $commentIds->all())
            ->join('users', 'users.uid', '=', 'comments.uid')
            ->join('trip_comments', 'trip_comments.cid', '=', 'comments.cid')
            ->orderBy('created')
            ->get()
            ->map(function ($comment) {
                $comment->created_at = Carbon::createFromTimestamp($comment->timestamp)->format('j. M Y');
                $comment->link = 'http://trip.ee/node/' . $comment->nid . '#comment-' . $comment->cid;
                $comment->link2 = 'http://trip2.test/node/' . $comment->nid . '#comment-' . $comment->cid;
                $comment->archivelink = 'https://web.archive.org/web/*/' . $comment->link;
                return $comment;
            });

        $nodes = $nodes->map(function ($node) use ($comments) {
            $node->comments = $comments->where('nid', $node->nid);
            return $node;
        })
            ->map(function ($node) {
                if ($node->created <= 654732000) { // 1. Oct 1990
                    if ($forum = Content::find($node->nid)) {
                        $node->created_at = $forum->created_at;
                    } else {
                        $node->created_at = Carbon::create(2001, 1, 1, 0, 0, 0);
                    }
                } else {
                    $node->created_at = Carbon::createFromTimestamp($node->created);
                }
                return $node;
            })
            ->map(function ($node) {
                $node->month = $node->created_at->format('Y.m');
                $node->monthTitle = $node->created_at->format('M Y');
                $node->created_at = $node->created_at->format('j. M Y');
                $node->changed_at = Carbon::createFromTimestamp($node->changed)->format('j. M Y');
                $node->link = 'http://trip.ee/node/' . $node->nid;
                $node->link2 = 'http://trip2.test/node/' . $node->nid;
                $node->archivelink = 'https://web.archive.org/web/*/' . $node->link;
                return $node;
            })
            ->sortBy('month')
            ->groupBy('month');

        return layout('Two')
            ->with('content', collect()
                ->push($this->links())
                //->push($this->pager('trip20.forums'))
                ->push('<br>')
                ->merge($nodes->flatMap(function ($monthNodes, $month) {
                    return collect()
                        ->push(component('Title')->is('small')->with('title', $monthNodes->first()->monthTitle . ' (' . $monthNodes->count() . ' posts)'))
                        ->merge($monthNodes->flatMap(function ($n) {
                            return collect()
                                ->push($this->card(collect()
                                    ->put('Title', $n->title)
                                    ->put('Author', $this->formatAuthor($n))
                                    ->put('Created at', $n->created_at)
                                    ->put('Links', $this->formatLinks($n))
                                    ->put('Body', $n->body)))
                                ->merge($n->comments->map(function ($c) {
                                    return component('Grid')
                                        ->with('cols', 2)
                                        ->with('widths', '1 10')
                                        ->with('items', collect()
                                            ->push('')
                                            ->push($this->card(
                                                collect()
                                                    ->put('Subject', $c->subject)
                                                    ->put('Created', $c->created_at)
                                                    ->put('Author', $this->formatAuthor($c))
                                                    ->put('Body', $c->comment)
                                            )));
                                }));
                        }));
                })))
            ->render();
    }

  public function usersIndex()
    {

        $pictureMap = [
            1 => 'https://web.archive.org/web/20070609230611if_/http://trip.ee/files/pictures/picture-1.jpg',
            2 => 'https://web.archive.org/web/20070609212559if_/http://www.trip.ee/files/pictures/picture-2.jpg',
            7 => 'https://web.archive.org/web/20070218154753if_/http://trip.ee:80/files/pictures/picture-7.jpg',
            23 => 'http://www.bluemoon.ee/~ahti/nepal/photos/ahti-holi-500x338.jpg',
            28 => 'https://www.photo.net/avatar/785095',
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
            ->where('uid', '>', 0)
            //->take(227)
            ->take(100)
            ->skip(request()->get('from', 0))
            ->orderBy('uid', 'asc')
            ->get()
            ->map(function ($user) use ($pictureMap, $friendMap) {
                $u1 = explode('@', $user->mail)[0];
                $u2 = explode('.', explode('@', $user->mail)[1])[0];
                if ($u1 == $u2) {
                    $user->mail = '-';
                }
                $u3 = explode('@', $user->init)[0];
                $u4 = explode('.', explode('@', $user->init)[1])[0];
                if ($u3 == $u4) {
                    $user->init = '-';
                }
                $limit = Carbon::create(2015, 1, 1, 0, 0, 0)->timestamp;
                $user->created = $user->created > 654732000 && $user->created != 946677600 && $user->created != 936306000 ? Carbon::createFromTimestamp($user->created)->format('j. M Y') : '-';
                $user->created = $user->created == 946677600 || $user->created == 936306000 ? Carbon::createFromTimestamp($user->created)->format('Y') : $user->created;
                $user->access = $user->access > 654732000 && $user->access < $limit ? Carbon::createFromTimestamp($user->access)->format('j. M Y') : '-';
                $user->login = $user->login > 654732000 && $user->access < $limit ? Carbon::createFromTimestamp($user->login)->format('j. M Y') : '-';
                $user->image = null;

                $user->archivepicture = null;
                if ($user->picture) {
                    $user->archivepicture = 'https://web.archive.org/web/*/trip.ee/' . $user->picture;
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
                    $user->name = $user->name . ' (' . $friendMap[$user->uid] . ')';
                }
                $user->content = DB::connection('trip')
                    ->table('node')
                    ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
                    ->select('node.*')
                    ->where('node.uid', '=', $user->uid == 1 ? 12 : $user->uid)
                    ->where('type', '=', 'trip_forum')
                    ->orderBy('node.created')
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

        return layout('Two')
            ->with('content', collect()
                ->push($this->links())
                ->push($this->pager('trip20.users'))
                ->push('<br>')
                ->push(component('Grid')
                    ->with('cols', 4)
                    ->with('gap', 2)
                    ->with('widths','6 2 10 9')
                    ->with('items', $users2->flatMap(function($user) {
                        return collect()
                            ->push(component('Title')
                                ->is('larger')
                                ->is('gray')
                                ->is('center')
                                ->with('title', $user->uid)
                            )
                            ->push($user->image ? '<img style="display: block; width: 128px;" src=' . $user->image . ' />' : '<div style="width: 128px;height: 128px;background:#ddd;"></div>')
                            ->push(collect()
                                ->push(component('Title')->is('small')->with('title', $user->name))
                                ->push($this->card(collect()
                                    ->put('Created', $user->created)
                                    ->put('Access', $user->access)
                                    ->put('Login', $user->login)
                                    ->put('Init email', $user->init)
                                    ->put('Email', $user->mail)
                                    ->put('Signature', "<br>".$user->signature)
                                ))
                                ->render()
                                ->implode('')
                            )
                            ->push(collect()
                                ->push(component('Title')->is('smallest')->with('title', count($user->content) > 0 ? 'Forum posts' : ''))
                                ->push(collect($user->content)->map(function($content) {
                                    return component('MetaLink')
                                        ->with('title', $content->title. '<br>'.$content->created)
                                        ->with('route', $content->archivelink)
                                    ;
                                })->render()->implode(''))
                                ->render()
                                ->implode('')
                            )
                        ;
                    }))
                )
            )
            ->render();

    }

    public function linksIndex()
    {
        $weblinks = DB::connection('trip')
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->join('weblink', 'weblink.nid', '=', 'node.nid')
            ->select('node.*', 'weblink.*')
            ->where('node.created', '<', Carbon::create(1999, 1, 1, 0, 0, 0)->timestamp)
            ->where('node.type', '=', 'weblink')
            ->take(100)
            ->skip(request()->get('from', 0))
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
                ->push($this->links())
                ->push($this->pager('trip20.links'))
                ->push('<br>')
                ->push(
                    component('Title')->is('small')->with('title', 'Reisiartiklid Eesti ajalehtedes 1995-1998')
                )
                ->merge($weblinks->map(function ($q) {
                    return component('Body')->with('body', format_body(collect()
                        ->push('####' . $q->title . ' ')
                        ->push('[' . $q->weblink . '](' . $q->archivelink . ')')
                        ->push('Original published at: ' . $q->created)
                        ->push('Added to Trip: ' . $q->changed)
                        ->implode("\n")));
                })))
            ->render();
    }

    public function imagesIndex()
    {
        $imageMap = [
            801 => 'https://web.archive.org/web/20070715103929im_/http://trip.ee/files/images/801.jpg',
            3841 => 'https://web.archive.org/web/20070701215242im_/http://www.trip.ee/files/images//tripi_kokkutulek_vallamael_006.preview.jpg',
            3842 => 'https://web.archive.org/web/20070701215436im_/http://www.trip.ee/files/images//tripi_kokkutulek_vallamael_016.preview.jpg',
            3850 => 'https://web.archive.org/web/20080313031838im_/http://trip.ee/files/images//tripi_kokkutulek_vallamael_055.thumbnail.jpg',
            // Tom Mariliis Portugalis
            1390 => 'https://web.archive.org/web/20070701220708im_/http://www.trip.ee/files/images//1390.jpg',
            826 => 'https://web.archive.org/web/20070701220058im_/http://www.trip.ee/files/images//826.jpg',
            827 => 'https://web.archive.org/web/20070701220749im_/http://www.trip.ee/files/images//827.jpg',
            829 => 'https://web.archive.org/web/20070610041813im_/http://www.trip.ee/files/images//829.jpg',
            830 => 'https://web.archive.org/web/20070610042336im_/http://www.trip.ee/files/images//830.jpg',
            831 => 'https://web.archive.org/web/20070701220514im_/http://www.trip.ee/files/images//831.jpg',
            1389 => 'https://web.archive.org/web/20070701220854im_/http://www.trip.ee/files/images//1389.jpg',
            // Immu
            1376 => 'https://web.archive.org/web/20070715134909im_/http://www.trip.ee/files/images//1376.jpg',
        ];

        $images = DB::connection('trip')
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->join('content_field_image', 'content_field_image.nid', '=', 'node.nid')
            ->join('files', 'files.fid', '=', 'content_field_image.field_image_fid')
            ->select('node.*', 'files.*')
            ->where('node.type', '=', 'trip_image')
            //->where('node.uid', 12)
            ->take(100)
            ->skip(request()->get('from', 0))
            ->orderBy('nid')
            ->get()
            ->map(function($image) use ($imageMap) {
                $image->link = '';
                if ($newImage = Content::find($image->nid)) {
                    $image->link = $newImage->imagePreset('medium');
                }
                if (array_key_exists($image->nid, $imageMap)) { 
                    $image->link = $imageMap[$image->nid];
                }
                $image->nodelink = 'https://trip.ee/node/'.$image->nid;
                $image->imagelink = 'https://trip.ee/images/original/'.basename($image->filepath);
                $image->nodearchivelink = 'https://web.archive.org/web/*/http://trip.ee/node/'.$image->nid;
                $image->imagearchivelink = 'https://web.archive.org/web/*/http://trip.ee/files/imagecache/trip_image_big/images/'.basename($image->filepath);
                return $image;
            })
        ;
        // /return $images;

        return layout('Two')
            ->with('content', collect()
                ->push($this->links())
                ->push($this->pager('trip20.images'))
                ->push('<br>')
            ->merge($images->map(function ($image) {
                return component('Grid')->with('gap',2)->with('items', collect()
                    ->push($this->card(collect()
                        ->put('Title', $image->title)
                        ->put('Created', $image->created)
                        ->put('Archive page', $image->nodearchivelink)
                    ))
                    ->push('<img width="300" src="'.$image->link.'" />')
                );
            }))
        )
        ->render();


    }
}
