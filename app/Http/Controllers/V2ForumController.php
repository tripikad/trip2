<?php

namespace App\Http\Controllers;

use Cache;
use Request;
use App\User;
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
        $topics = Topic::select('id', 'name')->get();

        $flights = Content::getLatestItems('flight', 3);
        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        return layout('2col')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans("content.$forumType.index.title"))
                )
                ->push(region(
                    'FilterHorizontal',
                    $destinations,
                    $topics,
                    $currentDestination,
                    $currentTopic,
                    $forums->currentPage(),
                    'v2.forum.index'
                ))
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
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
        $forum = Content::getItemBySlug($slug);
        $forumType = $forum->type;

        $user = auth()->user();
        $firstUnreadCommentId = $forum->vars()->firstUnreadCommentId;

        $flights = Content::getLatestItems('flight', 3);
        $travelmates = Content::getLatestItems('travelmate', 3);
        $news = Content::getLatestItems('news', 1);

        // Clear the unread cache

        if ($user) {
            $key = 'new_'.$forum->id.'_'.$user->id;
            Cache::store('permanent')->forget($key);
        }

        return layout('2col')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans("content.$forum->type.index.title"))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))

            ->with('content', collect()
                ->push(region('ForumPost', $forum))
                ->merge($forum->comments->map(function ($comment) use ($firstUnreadCommentId) {
                    return region('Comment', $comment, $firstUnreadCommentId);
                }))
                ->pushWhen($user && $user->hasRole('regular'), region('CommentCreateForm', $forum))
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
}
