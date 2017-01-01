<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Auth;
use Mail;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentController extends Controller
{
    protected $rules = [
        'body' => 'required',
    ];

    public function store(Request $request, $type, $content_id)
    {
        $this->validate($request, $this->rules);

        $fields = [
            'content_id' => $content_id,
            'status' => 1,
        ];
        $comment = Auth::user()->comments()->create(array_merge($request->all(), $fields));

        /*
        if ($followersEmails = $comment
                ->content
                ->followersEmails()
                ->forget(Auth::user()->id)
                ->toArray()
        ) {
            foreach ($followersEmails as $followerId => $followerEmail) {
                Mail::queue('email.follow.content', ['comment' => $comment], function ($mail) use ($followerEmail, $followerId, $comment) {
                    $mail->to($followerEmail)
                        ->subject(trans('follow.content.email.subject', [
                            'title' => $comment->content->title,
                        ]));

                    $swiftMessage = $mail->getSwiftMessage();
                    $headers = $swiftMessage->getHeaders();

                    $header = [
                        'category' => [
                            'follow_content',
                        ],
                        'unique_args' => [
                            'user_id' => (string) $followerId,
                            'content_id' => (string) $comment->content->id,
                            'content_type' => (string) $comment->content->type,
                        ],
                    ];

                    $headers->addTextHeader('X-SMTPAPI', format_smtp_header($header));
                });
            }
        }

        */
        if (in_array($comment->content->type, ['forum', 'buysell', 'expat', 'internal'])) {
            DB::table('users')->select('id')->chunk(1000, function ($users) use ($comment) {
                collect($users)->each(function ($user) use ($comment) {

                    // For each active user we store the cache key about new added comment

                    $key = 'new_'.$comment->content_id.'_'.$user->id;

                    // We will not overwrite the cache if there are unread comments already

                    if (! Cache::get($key, 0) > 0) {

                        // The cache value is new comment id, this helps us redirect user
                        // to the right place later

                        Cache::forever($key, $comment->id);
                    }
                });
            });
        }

        Log::info('New comment added', [
            'user' =>  Auth::user()->name,
            'body' =>  $request->get('body'),
            'link' => route('content.show', [$type, $content_id, '#comment-'.$comment->id]),
            'followers' => $comment
                ->content
                ->followersEmails()
                ->forget(Auth::user()->id)
                ->count(),
        ]);

        $content = $comment->content;

        $comments = new LengthAwarePaginator(
            $content->comments,
            $content->comments->count(),
            config('content_'.$type.'.index.paginate')
        );
        $comments->setPath(route($type.'.show', [$content->slug]));

        return redirect()
            ->route($type.'.show', [
                $content->slug,
                ($comments->lastPage() > 1 ? 'page='.$comments->lastPage() : '')
                    .'#comment-'.$comment->id,
            ]);
    }

    public function edit($id)
    {
        $comment = \App\Comment::findorFail($id);

        return \View::make('pages.comment.edit')
            ->with('comment', $comment)
            ->render();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rules);

        $comment = \App\Comment::findorFail($id);

        $fields = [
            'status' => 1,
        ];

        $comment->update(array_merge($request->all(), $fields), ['touch' => false]);

        return redirect()
            ->route($comment->content->type.'.show', [
                $comment->content->slug,
                '#comment-'.$comment->id,
            ]);
    }

    public function status($id, $status)
    {
        $comment = \App\Comment::findorFail($id);

        if ($status == 0 || $status == 1) {
            $comment->status = $status;
            $comment->save(['touch' => false]);

            return redirect()
                ->route($comment->content->type.'.show', [
                    $comment->content->slug,
                    '#comment-'.$comment->id,
                ])
                ->with('info', trans("comment.action.status.$status.info", [
                    'title' => $comment->title,
                ]));
        }

        return back();
    }
}
