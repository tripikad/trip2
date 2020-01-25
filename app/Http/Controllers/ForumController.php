<?php

namespace App\Http\Controllers;

use Log;
use Request;
use App\User;
use App\Image;
use App\Topic;
use App\Comment;
use App\Content;
use App\Destination;

class ForumController extends Controller
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

  public function miscIndex()
  {
    return $this->index('misc');
  }

  private function index($type)
  {
    $currentDestination = Request::get('destination');
    $currentTopic = Request::get('topic');

    $forums = Content::getLatestPagedItems($type, false, $currentDestination, $currentTopic, 'updated_at', [
      'unread_content',
      'views'
    ]);
    $destinations = Destination::select('id', 'name')->get();
    $topics = Topic::select('id', 'name')
      ->orderBy('name', 'asc')
      ->get();

    $flights = Content::getLatestItems('flight', 3);
    $travelmates = Content::getLatestItems('travelmate', 3);
    $news = Content::getLatestItems('news', 1);

    return layout('Two')
      ->with('title', trans("content.$type.index.title"))
      ->with('head_title', trans("content.$type.index.title"))
      ->with('head_description', trans("site.description.$type"))
      ->with('head_image', Image::getSocial())

      ->with('background', component('BackgroundMap'))
      ->with('color', 'gray')

      ->with(
        'header',
        region(
          'ForumHeader',
          collect()
            ->push(
              component('Title')
                ->is('gray')
                ->with('title', trans("content.$type.index.title"))
            )
            ->push(component('BlockHorizontal')->with('content', region('ForumLinks')))
            ->pushWhen(
              $type != 'misc',
              region(
                'FilterHorizontal',
                $destinations,
                $topics,
                $currentDestination,
                $currentTopic,
                $forums->currentPage(),
                'forum.index'
              )
            )
        )
      )

      ->with(
        'content',
        collect()
          ->merge(
            $forums->map(function ($forum) {
              return region('ForumRow', $forum);
            })
          )
          ->push(region('Paginator', $forums, $currentDestination, $currentTopic))
      )

      ->with(
        'sidebar',
        collect()
          ->push(region('ForumAbout', $type))
          ->push(component('Promo')->with('promo', 'sidebar_small'))
          ->push(component('Promo')->with('promo', 'sidebar_large'))
      )

      ->with(
        'bottom',
        collect()
          ->push(region('ForumBottom', $flights, $travelmates, $news))
          ->push(component('Promo')->with('promo', 'footer'))
      )

      ->with(
        'footer',
        collect()
          ->push(region('OfferSection'))
          ->push(region('FooterLight'))
          ->render()
          ->implode('')
      )
      ->render();
  }

  public function followIndex($user_id)
  {
    $user = User::findOrFail($user_id);
    $follows = $user->follows;

    $flights = Content::getLatestItems('flight', 3);
    $travelmates = Content::getLatestItems('travelmate', 3);
    $news = Content::getLatestItems('news', 1);

    return layout('Two')
      ->with('background', component('BackgroundMap'))
      ->with('color', 'gray')

      ->with(
        'header',
        region(
          'ForumHeader',
          collect()
            ->push(
              component('Title')
                ->is('gray')
                ->with('title', trans('follow.index.title'))
            )
            ->push(component('BlockHorizontal')->with('content', region('ForumLinks')))
        )
      )

      ->with(
        'content',
        collect()
          ->pushWhen($follows->count() == 0, component('Title')->with('title', trans('follow.index.empty')))
          ->merge(
            $user->follows->map(function ($follow) {
              return region('ForumRow', $follow->followable);
            })
          )
      )

      ->with(
        'sidebar',
        collect()
          ->push(component('Promo')->with('promo', 'sidebar_small'))
          ->push(component('Promo')->with('promo', 'sidebar_large'))
      )

      ->with(
        'bottom',
        collect()
          ->push(region('ForumBottom', $flights, $travelmates, $news))
          ->push(component('Promo')->with('promo', 'footer'))
      )

      ->with('footer', region('FooterLight'))

      ->render();
  }

  public function show($slug)
  {
    $user = auth()->user();
    $forum = Content::whereSlug($slug)
      ->with('flags', 'images', 'user', 'user.images', 'destinations', 'topics')
      ->withCount('views')
      ->when(!$user || !$user->hasRole('admin'), function ($query) use ($user) {
        return $query->whereStatus(1);
      })
      ->first();
    if (!$forum) {
      abort(404);
    }

    $forum->vars()->add_view;

    $comments = Comment::where('content_id', $forum->id)
      ->with('user', 'user.images', 'flags', 'content')
      ->when(!$user || !$user->hasRole('admin'), function ($query) use ($user) {
        return $query->whereStatus(1);
      })
      ->paginate(config('content.forum.paginate'));

    $anchor = '';
    $type = $forum->type;

    $firstUnreadCommentId = $forum->vars()->firstUnreadCommentId;

    $flights = Content::getLatestItems('flight', 3);
    $travelmates = Content::getLatestItems('travelmate', 3);
    $news = Content::getLatestItems('news', 1);

    $forum->vars()->update_content_read;

    if ($comments->total()) {
      $last_comment = Comment::select('id')
        ->where('content_id', $forum->id)
        ->when(!$user || !$user->hasRole('admin'), function ($query) use ($user) {
          return $query->whereStatus(1);
        })
        ->orderBy('id', 'desc')
        ->first();

      $anchor = '?page=' . $comments->lastPage() . '#comment-' . $last_comment->id;
    }

    return layout('Two')
      ->with('title', trans('content.forum.index.title'))
      ->with('head_title', $forum->vars()->title)
      ->with('head_description', $forum->vars()->description)
      ->with('head_image', Image::getSocial())

      ->with('background', component('BackgroundMap'))
      ->with('color', 'gray')

      ->with(
        'header',
        region(
          'ForumHeader',
          collect()
            ->push(
              component('Title')
                ->is('gray')
                ->with('title', trans("content.$forum->type.index.title"))
                ->with('route', route("$forum->type.index"))
            )
            ->push(component('BlockHorizontal')->with('content', region('ForumLinks')))
        )
      )

      ->with(
        'top',
        collect()->pushWhen(
          !$forum->status,
          component('HeaderUnpublished')->with('title', trans('content.show.unpublished'))
        )
      )

      ->with(
        'content',
        collect()
          ->push(region('ForumPost', $forum, 'forum.edit'))
          ->push(component('CommentInset')->with('content', region('PaginatorExtended', $comments)))
          ->pushWhen(
            $comments->total() > 1,
            component('BlockHorizontal')
              ->is('right')
              ->with(
                'content',
                collect()->push(
                  component('Link')
                    ->with('title', trans('comment.action.latest.comment'))
                    ->with('route', route('forum.show', [$forum->slug]) . $anchor)
                )
              )
          )
          ->merge(
            $comments->map(function ($comment) use ($firstUnreadCommentId) {
              return region('Comment', $comment, $firstUnreadCommentId, 'inset');
            })
          )
          ->push(component('CommentInset')->with('content', region('PaginatorExtended', $comments)))
          ->pushWhen($user && $user->hasRole('regular'), region('CommentCreateForm', $forum, 'inset'))
          ->push(component('Promo')->with('promo', 'body'))
      )

      ->with(
        'sidebar',
        collect()
          ->push(region('ForumAbout', $type))
          ->push(component('Promo')->with('promo', 'sidebar_small'))
          ->push(component('Promo')->with('promo', 'sidebar_large'))
      )

      ->with(
        'bottom',
        collect()
          ->push(region('ForumBottom', $flights, $travelmates, $news))
          ->push(component('Promo')->with('promo', 'footer'))
      )

      ->with(
        'footer',
        collect()
          ->push(region('OfferSection'))
          ->push(region('FooterLight'))
          ->render()
          ->implode('')
      )

      ->render();
  }

  public function create($type = 'forum')
  {
    $destinations = Destination::select('id', 'name')
      ->orderBy('name', 'asc')
      ->get();
    $topics = Topic::select('id', 'name')
      ->orderBy('name', 'asc')
      ->get();

    return layout('Two')
      ->with('background', component('BackgroundMap'))
      ->with('color', 'gray')

      ->with(
        'header',
        region(
          'ForumHeader',
          collect()
            ->push(
              component('Title')
                ->is('gray')
                ->with('title', trans('content.forum.index.title'))
                ->with('route', route('forum.index'))
            )
            ->push(component('BlockHorizontal')->with('content', region('ForumLinks')))
        )
      )

      ->with(
        'content',
        collect()
          ->push(component('Title')->with('title', trans('content.forum.create.title')))
          ->push(
            component('Form')
              ->with('id', 'ForumCreateForm')
              ->with('route', route('forum.store'))
              ->with(
                'fields',
                collect()
                  ->push(
                    component('FormRadio')
                      ->with('name', 'type')
                      ->with('value', $type)
                      ->with(
                        'options',
                        collect(['forum', 'buysell', 'expat', 'misc'])->map(function ($type) {
                          return collect()
                            ->put('id', $type)
                            ->put('name', trans("content.$type.index.title"));
                        })
                      )
                  )
                  ->push(
                    component('FormTextfield')
                      ->is('large')
                      ->with('title', trans('content.forum.edit.field.title.title'))
                      ->with('name', 'title')
                      ->with('value', old('title'))
                  )
                  ->push(
                    component('EditorComment')
                      ->with('title', trans('content.forum.edit.field.body.title'))
                      ->with('name', 'body')
                      ->with('value', old('body'))
                      ->with('rows', 20)
                  )
                  ->pushWhen(
                    $type != 'misc',
                    component('FormSelectMultiple')
                      ->with('name', 'destinations')
                      ->with('options', $destinations)
                      ->with('placeholder', trans('content.index.filter.field.destination.title'))
                  )
                  ->pushWhen(
                    $type != 'misc',
                    component('FormSelectMultiple')
                      ->with('name', 'topics')
                      ->with('options', $topics)
                      ->with('placeholder', trans('content.index.filter.field.topic.title'))
                  )
                  ->push(component('FormButton')->with('title', trans('content.create.submit.title')))
              )
          )
      )

      ->with(
        'sidebar',
        collect()->push(
          component('Block')
            ->is('gray')
            ->with(
              'content',
              collect()
                ->push(
                  component('Title')
                    ->is('smaller')
                    ->is('red')
                    ->with('title', trans('content.edit.notes.heading'))
                    ->with('route', route('forum.index'))
                )
                ->push(component('Body')->with('body', trans('content.edit.notes.body')))
            )
        )
      )

      ->with('footer', region('Footer'))

      ->render();
  }

  public function store()
  {
    $loggedUser = request()->user();

    $rules = [
      'title' => 'required',
      'body' => 'required',
      'type' => 'in:forum,buysell,expat,misc'
    ];

    $this->validate(request(), $rules);

    $forum = $loggedUser->contents()->create([
      'title' => request()->title,
      'body' => request()->body,
      'type' => request()->type,
      'status' => 1
    ]);

    if ($forum->type != 'misc') {
      $forum->destinations()->attach(request()->destinations);
      $forum->topics()->attach(request()->topics);
    }

    Log::info('New content added', [
      'user' => $forum->user->name,
      'title' => $forum->title,
      'type' => $forum->type,
      'body' => $forum->body,
      'link' => route("$forum->type.show", [$forum->slug])
    ]);

    return redirect()
      ->route("$forum->type.index")
      ->with(
        'info',
        trans('content.store.info', [
          'title' => $forum->title
        ])
      );
  }

  public function edit($id)
  {
    $forum = Content::findOrFail($id);

    $destinations = Destination::select('id', 'name')
      ->orderBy('name', 'asc')
      ->get();
    $topics = Topic::select('id', 'name')
      ->orderBy('name', 'asc')
      ->get();

    return layout('Two')
      ->with('background', component('BackgroundMap'))
      ->with('color', 'gray')

      ->with(
        'header',
        region(
          'ForumHeader',
          collect()
            ->push(
              component('Title')
                ->is('gray')
                ->with('title', trans('content.forum.index.title'))
                ->with('route', route('forum.index'))
            )
            ->push(component('BlockHorizontal')->with('content', region('ForumLinks')))
        )
      )

      ->with(
        'content',
        collect()
          ->push(component('Title')->with('title', trans('content.forum.edit.title')))
          ->push(
            component('Form')
              ->with('route', route('forum.update', [$forum]))
              ->with('method', 'PUT')
              ->with(
                'fields',
                collect()
                  ->push(
                    component('FormRadio')
                      ->with('name', 'type')
                      ->with('value', $forum->type)
                      ->with(
                        'options',
                        collect(['forum', 'buysell', 'expat', 'misc'])->map(function ($type) {
                          return collect()
                            ->put('id', $type)
                            ->put('name', trans("content.$type.index.title"));
                        })
                      )
                  )
                  ->push(
                    component('FormTextfield')
                      ->is('large')
                      ->with('title', trans('content.forum.edit.field.title.title'))
                      ->with('name', 'title')
                      ->with('value', old('title', $forum->title))
                  )
                  ->push(
                    component('EditorComment')
                      ->with('title', trans('content.forum.edit.field.body.title'))
                      ->with('name', 'body')
                      ->with('value', old('body', $forum->body))
                      ->with('rows', 20)
                  )
                  ->pushWhen(
                    $forum->type != 'misc',
                    component('FormSelectMultiple')
                      ->with('name', 'destinations')
                      ->with('options', $destinations)
                      ->with('value', $forum->destinations->pluck('id'))
                      ->with('placeholder', trans('content.index.filter.field.destination.title'))
                  )
                  ->pushWhen(
                    $forum->type != 'misc',
                    component('FormSelectMultiple')
                      ->with('name', 'topics')
                      ->with('options', $topics)
                      ->with('value', $forum->topics->pluck('id'))
                      ->with('placeholder', trans('content.index.filter.field.topic.title'))
                  )
                  ->push(component('FormButton')->with('title', trans('content.edit.submit.title')))
              )
          )
      )

      ->with(
        'sidebar',
        collect()->push(
          component('Block')
            ->is('gray')
            ->with(
              'content',
              collect()
                ->push(
                  component('Title')
                    ->is('smaller')
                    ->is('red')
                    ->with('title', trans('content.edit.notes.heading'))
                    ->with('route', route('forum.index'))
                )
                ->push(component('Body')->with('body', trans('content.edit.notes.body')))
            )
        )
      )

      ->with('footer', region('Footer'))

      ->render();
  }

  public function update($id)
  {
    $forum = Content::findOrFail($id);

    $rules = [
      'title' => 'required',
      'body' => 'required',
      'type' => 'in:forum,buysell,expat,misc'
    ];

    $this->validate(request(), $rules);

    $forum->update([
      'title' => request()->title,
      'body' => request()->body,
      'type' => request()->type
    ]);

    if ($forum->type != 'misc') {
      $forum->destinations()->sync(request()->destinations ?: []);
      $forum->topics()->sync(request()->topics ?: []);
    }

    return redirect()
      ->route('forum.show', [$forum->slug])
      ->with(
        'info',
        trans('content.update.info', [
          'title' => $forum->title
        ])
      );
  }
}
