<?php

namespace App\Http\Controllers;

use App;
use Cache;
use Request;
use App\User;
use App\Image;
use App\Topic;
use App\Content;
use App\Destination;

class V2ForumController extends Controller
{
    public function forumIndex()
    {
        return $this->index('forum');
    }

    public function buysellIndex()
    {
        return $this->index('buysell');
    }

    public function expatIndex()
    {
        return $this->index('expat');
    }

    private function index($forumType)
    {
        $currentDestination = Request::get('destination');
        $currentTopic = Request::get('topic');

        $forums = Content::getLatestPagedItems($forumType, false, $currentDestination, $currentTopic, 'updated_at');
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->orderBy('name')->get();

        $flights = Content::getLatestItems('flight', 3);
        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        return layout('2col')

            ->with('title', trans("content.$forumType.index.title"))
            ->with('head_title', trans("content.$forumType.index.title"))
            ->with('head_description', trans("site.description.$forumType"))
            ->with('head_image', Image::getSocial())

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->is('gray')
                    ->with('title', trans("content.$forumType.index.title"))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
                ->push(region(
                    'FilterHorizontal',
                    $destinations,
                    $topics,
                    $currentDestination,
                    $currentTopic,
                    $forums->currentPage(),
                    'forum.index'
                ))
            ))

            ->with('content', collect()
                ->merge($forums->map(function ($forum) {
                    return region('ForumRow', $forum);
                }))
                ->push(region('Paginator', $forums, $currentDestination, $currentTopic))
            )

            ->with('sidebar', collect()
                ->push(region('ForumAbout', $forumType))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('ForumBottom', $flights, $travelmates, $news))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function followIndex($user_id)
    {
        $user = User::findOrFail($user_id);
        $follows = $user->follows;

        $flights = Content::getLatestItems('flight', 3);
        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        return layout('2col')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->is('gray')
                    ->with('title', trans('follow.index.title'))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))

            ->with('content', collect()
                ->pushWhen($follows->count() == 0, component('Title')
                    ->with('title', trans('follow.index.empty'))
                )
                ->merge($user->follows->map(function ($follow) {
                    return region('ForumRow', $follow->followable);
                }))
            )

            ->with('sidebar', collect()
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('ForumBottom', $flights, $travelmates, $news))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function show($slug)
    {
        $user = auth()->user();
        $forum = Content::getItemBySlug($slug, $user);

        // TODO: Why?

        if (! $forum->first()) {
            abort(404);
        }

        $forumType = $forum->type;

        $firstUnreadCommentId = $forum->vars()->firstUnreadCommentId;

        $flights = Content::getLatestItems('flight', 3);
        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        // Clear the unread cache

        if ($user) {
            $key = 'new_'.$forum->id.'_'.$user->id;
            Cache::store('permanent')->forget($key);
        }

        $anchor = $forum->comments->count()
            ? '#comment-'.$forum->comments->last()->id
            : '';

        $anchor = $forum->comments->count()
            ? '#comment-'.$forum->comments->last()->id
            : '';

        return layout('2col')

            ->with('title', trans('content.forum.index.title'))
            ->with('head_title', $forum->getHeadTitle())
            ->with('head_description', $forum->getHeadDescription())
            ->with('head_image', Image::getSocial())

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->is('gray')
                    ->with('title', trans("content.$forum->type.index.title"))
                    ->with('route', route("$forum->type.index"))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))

            ->with('top', collect()->pushWhen(
                ! $forum->status,
                component('HeaderUnpublished')
                    ->with('title', trans('content.show.unpublished'))
            ))

            ->with('content', collect()
                ->push(region('ForumPost', $forum))
                ->pushWhen(
                    $forum->comments->count() > 1,
                    component('BlockHorizontal')
                        ->is('right')
                        ->with('content', collect()
                            ->push(component('Link')
                                ->with('title', trans('comment.action.latest.comment'))
                                ->with('route', route(
                                    'forum.show', [$forum->slug]).$anchor
                                )
                            )
                    )
                )
                ->merge($forum->comments->map(function ($comment) use ($firstUnreadCommentId) {
                    return region('Comment', $comment, $firstUnreadCommentId, 'inset');
                }))
                ->pushWhen($user && $user->hasRole('regular'), region('CommentCreateForm', $forum, 'inset'))
            )

            ->with('sidebar', collect()
                ->push(region('ForumAbout', $forumType))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('ForumBottom', $flights, $travelmates, $news))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function create()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->create('forum');
    }

    public function edit($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->edit('forum', $id);
    }

    public function store()
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'forum');
    }

    public function update($id)
    {
        return App::make('App\Http\Controllers\ContentController')
            ->store(request(), 'forum', $id);
    }
}
