<?php

namespace App\Http\Controllers;

use App\Image;
use App\Topic;
use App\Content;
use App\Destination;

class VideoController extends Controller
{
    public function index()
    {
        //$travelmates = Content::getLatestPagedItems('travelmate', 24);
        $photos = Content::getLatestPagedItems('photo', 12);
        $destinations = Destination::select('id', 'name')->get();
        $topics = Topic::select('id', 'name')->orderBy('name', 'asc')->get();

        $flights = Content::getLatestItems('flight', 3);
        $forums = Content::getLatestPagedItems('forum', 3, null, null, 'updated_at');
        $news = Content::getLatestItems('news', 1);

        return layout('Two')

            ->with('title', trans('content.video.index.title'))
            ->with('head_title', trans('content.video.index.title'))
            ->with('head_description', trans('site.description.video'))
            ->with('head_image', Image::getSocial())

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.video.index.title'))
                    ->with('route', route('video.index'))
                )
            ))

            ->with('top', collect()
                ->push(component('MediaMap'))
            )

            ->with('content', collect()

                ->push(region(
                    'FilterHorizontal',
                    $destinations,
                    null,
                    null,
                    null,
                    $photos->currentPage(),
                    'videos.index'
                ))
                ->push(component('Grid2')
                    ->with('gutter', true)
                    ->with('items', $photos->map(function ($photo) {
                        return component('VideoCard')
                            ->with('thumbnailImgUrl', $photo->imagePreset('small_square'))
                            ->with('route', route('video.show', [$photo->slug]))
                            ->with('user', component('UserImage')
                                ->with('route', route('user.show', [$photo->user]))
                                ->with('image', $photo->user->imagePreset('small_square'))
                                ->with('rank', $photo->user->vars()->rank)
                                ->with('size', 55)
                                ->with('border', 3)
                            )
                            ->with('title', 'Lorem ipsumdsdsd Lorem ipsum Lorem ipsum ')
                            ->with('meta', component('Meta')->with('items', collect()
                                ->push(component('MetaLink')
                                    ->is('cyan')
                                    ->with('title', $photo->user->vars()->name)
                                    ->with('route', route('user.show', [$photo->user]))
                                )
                                ->merge($photo->destinations->take(3)
                                    ->map(function ($destination) {
                                        return component('Tag')
                                            ->is('orange')
                                            ->with('title', $destination->name)
                                            ->with('route', route('destination.showSlug', [$destination->slug]));
                                    }))
                                ->pushWhen(
                                    $photo->destinations->count() > 3,
                                    component('Tag')
                                        ->is('orange')
                                        ->with('title', '...')
                                )
                                ->merge($photo->topics->take(3)
                                    ->map(function ($topic) {
                                        return component('MetaLink')
                                            ->with('title', $topic->name);
                                    })
                                )
                                ->pushWhen(
                                    $photo->topics->count() > 3,
                                    component('MetaLink')
                                        ->with('title', '...')
                                )
                            ));
                    })
                    )
                )
                ->push(region('Paginator', $photos))
            )

            ->with('sidebar', collect()
                ->push(component('Block')
                    ->with('content', collect()
                        ->push(component('Body')
                            ->with('body', trans('content.video.description.text'))
                        )
                    ))
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )

            ->with('bottom', collect()
                ->push(region('TravelmateBottom', $flights, $forums, $news))
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'))

            ->render();
    }


    public function show($slug)
    {
        $user = auth()->user();
        $video = Content::getItemBySlug($slug, $user);

        return layout('Two')

            ->with('title', trans('content.video.index.title'))
            ->with('head_title', trans('content.video.index.title'))
            ->with('head_description', trans('site.description.video'))
            ->with('head_image', Image::getSocial())

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->is('large')
                    ->with('title', trans('content.video.index.title'))
                    ->with('route', route('video.index'))
                )
            ))

            ->with('top', collect()->pushWhen(
                ! $video->status,
                component('HeaderUnpublished')
                    ->with('title', trans('content.show.unpublished'))
            ))

            ->with('content', collect()
                //->push(component('Title')->with('title', $video->vars()->title))
                ->push(component('VideoCard')
                    ->with('title', $video->vars()->title)
                    ->with('embed', true)
                    //->with('route', route('video.show', [$video->slug]))
                    ->with('user', component('UserImage')
                        ->with('route', route('user.show', [$video->user]))
                        ->with('image', $video->user->imagePreset('small_square'))
                        ->with('rank', $video->user->vars()->rank)
                        ->with('size', 55)
                        ->with('border', 3)
                    )
                    //->with('title', 'Lorem ipsumdsdsd Lorem ipsum Lorem ipsum ')
                    ->with('meta', component('Meta')->with('items', collect()
                        ->push(component('MetaLink')
                            ->is('cyan')
                            ->with('title', $video->user->vars()->name)
                            ->with('route', route('user.show', [$video->user]))
                        )
                        ->merge($video->destinations->take(3)
                            ->map(function ($destination) {
                                return component('Tag')
                                    ->is('orange')
                                    ->with('title', $destination->name)
                                    ->with('route', route('destination.showSlug', [$destination->slug]));
                            }))
                        ->pushWhen(
                            $video->destinations->count() > 3,
                            component('Tag')
                                ->is('orange')
                                ->with('title', '...')
                        )
                        ->merge($video->topics->take(3)
                            ->map(function ($topic) {
                                return component('MetaLink')
                                    ->with('title', $topic->name);
                            })
                        )
                        ->pushWhen(
                            $video->topics->count() > 3,
                            component('MetaLink')
                                ->with('title', '...')
                        )
                    ))
                )

                ->push(component('Body')->with('body', 'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum
                Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum
                Lorem ipsumLorem ipsum'))
                ->push(component('Meta')
                    ->with('items', collect()
                        /*->push(component('MetaLink')
                            ->with('title', $video->vars()->created_at)
                        )
                        ->pushWhen(
                            $user && $user->hasRoleOrOwner('admin', $video->user->id),
                            component('MetaLink')
                                ->with('title', trans('content.action.edit.title'))
                                ->with('route', route('travelmate.edit', [$video]))
                        )
                        ->merge($video->destinations->map(function ($tag) {
                            return component('Tag')->is('orange')->with('title', $tag->name);
                        }))
                        ->merge($video->topics->map(function ($tag) {
                            return component('MetaLink')->with('title', $tag->name);
                        }))
                        ->pushWhen($user && $user->hasRole('admin'), component('Form')
                            ->with('route', route(
                                'content.status',
                                [$video->type, $video, (1 - $video->status)]
                            ))
                            ->with('fields', collect()
                                ->push(component('FormLink')
                                    ->with(
                                        'title',
                                        trans("content.action.status.$video->status.title")
                                    )
                                )
                            )
                        )*/
                    )
                )
                ->push(component('Body')->is('responsive')->with('body', $video->vars()->body))
                ->merge($video->comments->map(function ($comment) {
                    return region('Comment', $comment);
                }))
                ->pushWhen(
                    $user,
                    region('CommentCreateForm', $video)
                )
            )

            ->with('sidebar', collect()
                ->push(component('Promo')->with('promo', 'sidebar_small'))
                ->push(component('Promo')->with('promo', 'sidebar_large'))
            )


            ->with('footer', region('Footer'))

            ->render();
    }
}
