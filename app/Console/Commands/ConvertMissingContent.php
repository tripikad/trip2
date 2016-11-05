<?php

namespace App\Console\Commands;

use Illuminate\Database\Eloquent\Model;
use App;
use App\Content;
use App\User as User;
use Illuminate\Support\Facades\Hash;

class ConvertMissingContent extends ConvertBase
{
    protected $signature = 'convert:missingContent';
    protected $targetUserId = null;

    protected $contentTypeMapping = [
        'story' => 'news',
        'trip_blog' => 'blog',
        'trip_forum' => 'forum',
        'trip_forum_other' => 'forum',
        'trip_forum_expat' => 'expat',
        'trip_forum_buysell' => 'buysell',
        'trip_forum_travelmate' => 'travelmate',
        'trip_image' => 'photo',
        'trip_offer' => 'forum',
    ];

    public function getNodes($type)
    {
        $query = \DB::connection($this->connection)
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->select('node.*', 'node_revisions.body')
            ->where('node.uid', '=', 0)
            ->where('node.status', '=', 1)
            ->where('node.type', '=', $type)
            ->orderBy('node.last_comment', 'desc');

        return $query;
    }

    public function convertNode($node, $modelname, $type, $route = '')
    {
        if (! $modelname::find($node->nid)) {
            $model = new $modelname;

            $model->id = $node->nid;
            $model->type = $type;
            $model->user_id = $this->targetUserId;
            $model->title = $this->cleanAll($node->title);
            $model->body = $this->clean($node->body);

            $model->start_at = isset($node->start_at) ? $node->start_at : null;
            $model->end_at = isset($node->end_at) ? $node->end_at : null;
            $model->duration = isset($node->duration) ? $this->cleanAll($node->duration) : null;
            $model->price = (isset($node->price) && is_int((int) $node->price)) ? $node->price : null;

            $model->status = 1;

            //todo: slug also!!!

            $model->save();

            $this->convertComments($node->nid, 1);
            $this->convertFlags($node->nid, 'App\Content', 'node');

            if ($route != '') {
                if ($alias = $this->getNodeAlias($node->nid)) {
                    $this->convertStaticAlias($route, $alias->dst, $type, $node->nid);
                }
            } else {
                $this->convertNodeAlias($node->nid, 'App\Content', 'node');
            }

            // We re-save the model, now with original timestamps since the the converters above
            // might have been touching the timestamps

            $model->created_at = \Carbon\Carbon::createFromTimeStamp($node->created);
            $model->updated_at = \Carbon\Carbon::createFromTimeStamp($node->last_comment);
            $model->timestamps = false;

            $model->save();

            return $model;
        }
    }

    public function convertComments($nid, $status = 0)
    {
        $comments = $this->getComments($nid)->where('status', '=', $status)->get();

        foreach ($comments as $comment) {
            $model = new \App\Comment;

            $model->id = $comment->cid;
            $model->user_id = $this->targetUserId;
            $model->content_id = $comment->nid;
            $model->body = $this->clean($comment->comment);
            $model->status = 1 - $comment->status;
            $model->created_at = \Carbon\Carbon::createFromTimeStamp($comment->timestamp);
            $model->updated_at = \Carbon\Carbon::createFromTimeStamp($comment->timestamp);
            $model->timestamps = false;

            $model->save();

            $this->convertFlags($comment->cid, 'App\Comment', 'comment');
        }
    }

    protected function createTargetUser()
    {
        $user = User::where('name', '=', 'Tripi külastaja')->first();
        if (! $user) {
            $model = new User();
            $model->name = 'Tripi külastaja';
            $model->password = Hash::make(str_random(8));
            $model->role = 'regular';
            $model->created_at = \Carbon\Carbon::createFromDate(1999, 5, 5);
            $model->timestamps = false;

            $model->save();

            return $model;
        }

        return $user;
    }

    public function handle()
    {
        $this->line('Converting missing content');

        if (! $targetUserId = $this->createTargetUser()) {
            $this->line('Invalid user');
            exit(0);
        }

        foreach ($this->contentTypes as $type) {
            $nodes = $this->getNodes($type)->get();

            foreach ($nodes as $node) {
                $this->convertNode($node, 'App\Comment', $this->contentTypeMapping[$type]);
            }
        }

        $this->line('Done!');
    }
}
