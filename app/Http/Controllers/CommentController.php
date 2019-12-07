<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use Mail;
use App\Comment;
use Illuminate\Http\Request;
use App\Mail\NewCommentFollow;

class CommentController extends Controller
{
    public function store($type, $content_id)
    {
        $rules = [
            'body' => 'required'
        ];

        $this->validate(request(), $rules, ['body.required' => 'Kommentaari sisu on kohustuslik']);

        $comment = Auth::user()
            ->comments()
            ->create([
                'body' => request()->body,
                'content_id' => $content_id,
                'status' => 1
            ]);

        $follower_emails = $comment->content
            ->followersEmails()
            ->forget(Auth::user()->id)
            ->toArray();
        if ($follower_emails) {
            foreach ($follower_emails as $follower_id => &$follower_email) {
                Mail::to($follower_email)->queue(new NewCommentFollow($follower_id, $comment));
            }
        }

        Log::info('New comment added', [
            'user' => $comment->user->name,
            'body' => $comment->body,
            'link' => route('content.show', [$type, $comment->content->id, '#comment-' . $comment->id])
        ]);

        if ($comment->content->type == 'internal') {
            return redirect()->route($comment->content->type . '.show', [
                $comment->content,
                '#comment-' . $comment->id
            ]);
        }

        $append = '';

        if (in_array($comment->content->type, ['forum', 'expat', 'buysell', 'misc'])) {
            $user = auth()->user();
            $comments = Comment::where('content_id', $comment->content->id)
                ->when(!$user || !$user->hasRole('admin'), function ($query) use ($user) {
                    return $query->whereStatus(1);
                })
                ->count();

            $last_page = ceil($comments / config('content.forum.paginate'));

            $append = 'page=' . $last_page;
        }

        return redirect()
            ->route($comment->content->type . '.show', [$comment->content->slug, $append . '#comment-' . $comment->id])
            ->with('info', trans('comment.created.title', ['title' => $comment->vars()->title()]));
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);

        return layout('Two')
            ->with(
                'header',
                region('StaticHeader', collect()->push(component('Title')->with('title', trans('comment.edit.title'))))
            )

            ->with(
                'content',
                collect()->push(
                    component('Form')
                        ->with('route', route('comment.update', [$comment]))
                        ->with(
                            'fields',
                            collect()
                                ->push(
                                    component('EditorComment')
                                        ->with('title', trans('comment.edit.body.title'))
                                        ->with('name', 'body')
                                        ->with('value', old('body', $comment->body))
                                )
                                ->push(component('FormButton')->with('title', trans('comment.edit.submit.title')))
                        )
                )
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function update($id)
    {
        $rules = [
            'body' => 'required'
        ];

        $this->validate(request(), $rules);

        $comment = Comment::findorFail($id);

        $comment->update(['body' => request()->body], ['touch' => false]);

        if ($comment->content->type == 'internal') {
            return redirect()->route($comment->content->type . '.show', [
                $comment->content,
                '#comment-' . $comment->id
            ]);
        }

        $append = '';

        if (in_array($comment->content->type, ['forum', 'expat', 'buysell', 'misc'])) {
            $user = auth()->user();
            $comments = Comment::where('content_id', $comment->content->id)
                ->when(!$user || !$user->hasRole('admin'), function ($query) use ($user) {
                    return $query->whereStatus(1);
                })
                ->count();

            $last_page = ceil($comments / config('content.forum.paginate'));

            $append = 'page=' . $last_page;
        }

        return redirect()->route($comment->content->type . '.show', [
            $comment->content->slug,
            $append . '#comment-' . $comment->id
        ]);
    }

    public function status($id, $status)
    {
        $comment = \App\Comment::findorFail($id);

        if ($status == 0 || $status == 1) {
            $comment->status = $status;
            $comment->save(['touch' => false]);

            backToAnchor('#comment-' . $comment->id)->with(
                'info',
                trans("comment.action.status.$status.info", [
                    'title' => $comment->title
                ])
            );
        }

        return back();
    }
}
