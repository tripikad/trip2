<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Destination;
use App\Topic;
use App\Flag;
use App\Content;
use Cache;

class RemoveDuplicates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-assigns removable destinations and topics ID-s after that removes duplicate destinations and topics';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $topics = Topic::select(['id', 'name'])->whereIn('id', function ($query) { $query->select('id')->from('topics')->groupBy('name')->havingRaw('count(*) > 1'); })->get();
        $destinations = Destination::select(['id', 'name'])->whereIn('id', function ($query) { $query->select('id')->from('destinations')->groupBy('name')->havingRaw('count(*) > 1'); })->get();


        $removable = [
            'destinations' => [],
            'topics' => [],
        ];

        $replaceable = [
            'destinations' => [],
            'topics' => [],
        ];

        if (isset($topics) && count($topics)) {
            foreach ($topics as $topic) {
                $removable['topics'][] = $topic->id;

                $new_topic = Topic::select('id')->where('name', $topic->name)->where('id', '!=', $topic->id)->first();
                $replaceable['topics'][] = $new_topic->id;
            }
        }

        if (isset($destinations) && count($destinations)) {
            foreach ($destinations as $destination) {
                $removable['destinations'][] = $destination->id;

                $new_destination = Destination::select('id')->where('name', $destination->name)->where('id', '!=', $destination->id)->first();
                $replaceable['destinations'][] = $new_destination->id;
            }
        }

        if (! empty($removable['destinations'])) {
            foreach ($removable['destinations'] as $key => $destination) {
                if (Content::leftJoin('content_destination', 'contents.id', '=', 'content_destination.content_id')->where('content_destination.destination_id', $destination)->update(['content_destination.destination_id' => $replaceable['destinations'][$key]])) {
                    $this->info('content_destination.destination_id='.$destination.' MODIFIED WITH destination_id='.$replaceable['destinations'][$key]);
                }

                if (Flag::where('flaggable_id', $destination)->where('flaggable_type', 'App\Destination')->update(['flaggable_id' => $replaceable['destinations'][$key]])) {
                    $this->info('flags App\Destination flaggable_id='.$destination.' MODIFIED WITH flaggable_id='.$replaceable['destinations'][$key]);
                }

                Cache::forget('popular.destinations.root'.$destination);
                $this->info('Cache "popular.destinations.root.'.$destination.'" cleared');
            }

            if (Destination::whereIn('id', $removable['destinations'])->delete()) {
                $this->info('Destinations: ' . implode(', ', $removable['destinations']) . ' removed' . "\n");

                Cache::forget('destination.names');
                $this->info('Cache "destination.names" cleared');

                Destination::rebuild(true);
                $this->info('Destinations tree has been rebuilt'."\n\n");
            }
        }

        if (! empty($removable['topics'])) {
            foreach ($removable['topics'] as $key => $topic) {
                if (Content::leftJoin('content_topic', 'contents.id', '=', 'content_topic.content_id')->where('content_topic.topic_id', $topic)->update(['content_topic.topic_id' => $replaceable['topics'][$key]])) {
                    $this->info('content_topic.topic_id='.$topic.' MODIFIED WITH topic_id='.$replaceable['topics'][$key]);
                }

                /*if (Flag::where('flaggable_id', $topic)->where('flaggable_type', 'App\Topic')->update(['flaggable_id' => $replaceable['topics'][$key]])) {
                    $this->info('flags App\Topic flaggable_id='.$topic.' MODIFIED WITH flaggable_id='.$replaceable['topics'][$key]);
                }*/
            }

            if (Topic::whereIn('id', $removable['topics'])->delete()) {
                $this->info('Topics: ' . implode(', ', $removable['topics']) . ' removed');
            }
        }

        if (empty($removable['topics']) && empty($removable['destinations'])) {
            Cache::forget('destination.names');
            $this->info('Cache "destination.names" cleared');
            $this->info('There isn\'t any duplicate destinations or topics.');
        }
    }
}
