<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Content;
use App\Topic;
class ForumMiscTopic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:misctopic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'updates content with topic id 5000 to misc';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('finding all content where topic has id of 5000');

        $items = Content::whereType('forum')->join('content_topic', 'content_topic.content_id', '=', 'contents.id')
            ->select('contents.*')
            ->where('content_topic.topic_id', '=', 5000)->get();

        $this->info('Converting content');

        $items->each(function ($item){
            $item->type = 'misc';
            $item->save();
            $item->topics()->detach(5000);
        });

        $this->info('delete the topic misc');

        $topic = Topic::find(5000);
        $topic->delete();
    }
}
