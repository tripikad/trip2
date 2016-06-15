<?php

namespace App\Console\Commands;

use DB;
use App\Comment;
use App\Content;

class ConvertOldUser extends ConvertBase
{
    protected $signature = 'convert:olduser {uid}';

    public function handle()
    {
        $uid = $this->argument('uid');

        $this->convertUser($uid);

        $nodes = $this->getNodes('trip_forum')->where('node.uid', '=', $uid)->get();

        foreach ($nodes as $node) {

            // TODO
        }

        $comments = DB::connection($this->connection)
            ->table('comments')
            ->where('uid', '=', $uid)
            ->where('status', '=', 0)
            ->get();

        $this->info('Converting comments');

        foreach ($comments as $comment) {
            if (Content::find($comment->nid) && ! Comment::find($comment->cid)) {
                $model = new Comment;

                $model->id = $comment->cid;
                $model->user_id = $comment->uid;
                $model->content_id = $comment->nid;
                $model->body = $this->clean($comment->comment);
                $model->status = 1 - $comment->status;
                $model->created_at = \Carbon\Carbon::createFromTimeStamp($comment->timestamp);
                $model->updated_at = \Carbon\Carbon::createFromTimeStamp($comment->timestamp);
                $model->timestamps = false;

                $model->save();

                $this->line('Converting comment '.$comment->cid);
            }
        }
    }
}
