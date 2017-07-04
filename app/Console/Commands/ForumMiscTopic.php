<?php

namespace App\Console\Commands;

use App\Topic;
use App\Content;
use Illuminate\Console\Command;

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

        $urls = collect([
            'https://trip.ee/foorum/uldfoorum/filmid-dokumentaalfilmid-ja-tv-seriaalid',
            'https://trip.ee/foorum/uldfoorum/eesti-mainimine-filmides',
            'https://trip.ee/foorum/uldfoorum/oleks-vaja-eestis-aatikat',
            'https://trip.ee/foorum/uldfoorum/uurimistoeoe-lugemiseks',
            'https://trip.ee/foorum/uldfoorum/filipiinide-naised',
            'https://trip.ee/foorum/uldfoorum/kiire-id-kaardi-lugeja-tai-krabi',
            'https://trip.ee/foorum/uldfoorum/huvitavad-templid-passis',
            'https://trip.ee/foorum/uldfoorum/asjade-toimetamine-kanaaridelt-eestisse',
            ]);

        $content = $urls->map(function ($url) {
            return collect(explode('/', $url))->last();
        })->map(function ($slug) {
            return \App\Content::whereSlug($slug)->first();
        });

        /*
        $items = Content::whereType('forum')->join('content_topic', 'content_topic.content_id', '=', 'contents.id')
            ->select('contents.*')
            ->where('content_topic.topic_id', '=', 5000)->get();*/

        $this->info('Converting content');

        $content->each(function ($item) {
            $item->type = 'misc';
            $item->timestamps = false;
            $item->save();
            $item->topics()->detach();
            $item->destinations()->detach();
        });

        $this->info('delete the topic misc');

        $topic = Topic::findOrFail(5000);
        $topic->delete();
    }
}
