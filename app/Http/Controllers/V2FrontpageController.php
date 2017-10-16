<?php

namespace App\Http\Controllers;

use Cache;
use App\Poll;
use App\Image;
use App\Content;
use App\Destination;

class V2FrontpageController extends Controller
{
    public function index()
    {
        $loggedUser = auth()->user();

        $flights = Content::getLatestItems('flight', 9, 'id');
        $forums = Content::getLatestItems('forum', 18, 'updated_at', ['unread_content']);
        $news = Content::getLatestItems('news', 6, 'id');
        $shortNews = Content::getLatestItems('shortnews', 4, 'id');
        $blogs = Content::getLatestItems('blog', 3, 'id');
        $photos = Content::getLatestItems('photo', 9, 'id');
        $travelmates = Content::getLatestItems('travelmate', 5, 'id');

        $destinations = Cache::remember('destinations_with_slug', 30, function () {
            return Destination::select('id', 'name', 'slug')->get();
        });

        $layout = layout('frontpage');

        $quiz = Poll::getUnansweredQuizOrQuestionnaire();

        if ($quiz->isNotEmpty()) {
            $quiz = $quiz->first();
            $route = $loggedUser ? route('quiz.answer', ['slug' => $quiz->content->slug]) : route('login.form');
            $layout->with('promobar', component('PromoBar')
                ->with('title', trans('frontpage.index.poll.promo', ['title' => $quiz->name]))
                ->with('route_title', trans('frontpage.index.poll.promo.route'))
                ->with('route', $route)
            );
        }

        $poll_cache_minutes = 15;
        $polls = collect();
        $poll_field = null;
        $poll_results = [];
        $poll = null;

        if ($loggedUser) {
            $polls = Poll::getUnansweredPollsWoDestination();
        }

        if ($polls->isNotEmpty()) {
            $poll = $polls->first();
            $poll_field = $poll->poll_fields->first();
        } else {
            $polls = Poll::getPollsWoDestination();

            if ($polls->isNotEmpty()) {
                $poll = $polls->first();
                $poll_field = $poll->poll_fields->first();
                $poll_results = $poll_field->getParsedResults();
            }
        }

        return $layout

            ->with('title', trans('site.about'))
            ->with('head_title', trans('site.about'))
            ->with('head_description', trans('site.description.main'))
            ->with('head_image', Image::getSocial())

            ->with('header', region('FrontpageHeader', $destinations))

            ->with('top', collect()
                ->push(region('FrontpageFlight', $flights->take(3)))
                ->push(component('BlockHorizontal')
                    ->is('center')
                    ->with('content', collect()->push(component('Link')
                        ->is('blue')
                        ->with('title', trans('frontpage.index.all.offers'))
                        ->with('route', route('flight.index'))
                    ))
                )
                ->pushWhen(! $loggedUser, '&nbsp;')
                ->pushWhen(! $loggedUser, region('FrontpageAbout'))
            )

            ->with('content', collect()
                ->push(component('BlockTitle')
                    ->with('title', trans('frontpage.index.forum.title'))
                    ->with('route', route('forum.index'))
                )
                ->merge($forums->take($forums->count() / 2)->map(function ($forum) {
                    return region('ForumRow', $forum);
                }))
                ->push(component('Promo')->with('promo', 'body'))
                ->merge($forums->slice($forums->count() / 2)->map(function ($forum) {
                    return region('ForumRow', $forum);
                }))
            )

            ->with('sidebar', collect()
                ->push('&nbsp')
                ->push(component('Block')->with('content', collect()
                    ->merge(collect(['forum', 'buysell', 'expat', 'misc'])
                        ->flatMap(function ($type) use ($loggedUser) {
                            return collect()
                                ->push(component('Link')
                                    ->is('large')
                                    ->with('title', trans("content.$type.index.title"))
                                    ->with('route', route("$type.index"))
                                )
                                ->pushWhen(
                                    ! $loggedUser,
                                    component('Body')
                                        ->is('gray')
                                        ->with('body', trans("site.description.$type"))
                                );
                        })
                    )
                    ->pushWhen($loggedUser, component('Link')
                        ->is('large')
                        ->with('title', trans('menu.user.follow'))
                        ->with('route', route('follow.index', [$loggedUser]))
                    )
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRole('admin'),
                        component('Link')
                            ->is('large')
                            ->with('title', trans('menu.auth.admin'))
                            ->with('route', route('internal.index'))
                    )
                ))
                ->pushWhen($loggedUser && $loggedUser->hasRole('regular'), component('Button')
                    ->with('title', trans('content.forum.create.title'))
                    ->with('route', route('forum.create', ['forum']))
                )
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
                ->push(component('AffHotelscombined'))
                ->when($poll_field && $poll, function ($collection) use ($poll_field, $poll_results, $poll) {
                    $options = json_decode($poll_field->options, true);

                    if (isset($options['image_id'])) {
                        $image = Image::findOrFail($options['image_id']);
                        $image_small = $image->preset('xsmall_square');
                        $image_large = $image->preset('large');
                    }

                    return $collection->push(component('Block')
                        ->is('gray')
                        ->with('content', collect()
                            ->push(component('Title')
                                ->with('title', trans('content.poll.edit.poll'))
                                ->is('small')
                            )
                            ->push(component('PollAnswer')
                                ->with('options', json_decode($poll_field->options, true))
                                ->with('type', $poll_field->type)
                                ->with('id', $poll->id)
                                ->with('results', $poll_results)
                                ->with('image_small', isset($image_small) ? $image_small : '')
                                ->with('image_large', isset($image_large) ? $image_large : '')
                                ->with('answer_trans', trans('content.poll.answer'))
                                ->with('select_error', $poll_field->type == 'radio' ?
                                    trans('content.poll.answer.error.select.one') :
                                    trans('content.poll.answer.error.select.multiple')
                                )
                                ->with('save_error', trans('content.poll.answer.error.save'))
                            )
                        )
                    );
                })
            )

            ->with('bottom1', collect()
                ->merge(region('FrontpageNews', $news))
            )

            ->with('shortNews', collect()
                ->merge(region('FrontpageShortnews', $shortNews))
                ->push(component('BlockTitle')
                    ->with('title', trans('frontpage.index.photo.title'))
                    ->with('route', route('photo.index'))
                )
            )

            ->with('bottom2', region(
                'PhotoRow',
                $photos,
                collect()
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRole('regular'),
                        component('Button')
                            ->is('transparent')
                            ->with('title', trans('content.photo.create.title'))
                            ->with('route', route('photo.create'))
                    )
            ))

            ->with('bottom3', collect()
                ->push(region('FrontpageBottom', $flights->slice(3), $travelmates))
                ->push(component('Block')
                    ->with('title', trans('frontpage.index.blog.title'))
                    ->with('route', route('blog.index'))
                    ->with('content', collect()
                        ->push(component('Grid3')
                            ->with('items', $blogs->map(function ($blog) {
                                return region('BlogCard', $blog);
                            }))
                        )
                    )
                )
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }
}
