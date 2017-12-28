<?php

namespace App\Console\Commands;

use App\Topic;
use App\Carrier;
use App\Content;
use App\Destination;
use Illuminate\Console\Command;

class GenerateKeywords extends Command
{
    protected $signature = 'generate:keywords';

    protected $destinations;
    protected $topics;
    protected $carriers;

    protected $totalSize;
    protected $chunkSize;

    public function __construct()
    {
        parent::__construct();

        $this->totalSize = config('similars.totalsize');
        $this->chunkSize = config('similars.chunksize');
    }

    public function handle()
    {
        $this->destinations = $this->getDestinations();
        $this->topics = $this->getTopics();
        $this->carriers = $this->getCarriers();

        $this->info("\nCleaning up previous keywords and similars");

        $this->cleanupMeta();

        $totalSize = $this->totalSize;
        $chunkSize = $this->chunkSize;
        $chunkCount = $totalSize / $chunkSize;

        $count = 0;

        $progress = $this->output->createProgressBar($totalSize);

        $this->info("Generating keywords\n");

        // We iterate over the content latest modified, going back in time
        // until we hit config('similars.totalsize') / env('SIMILARS_TOTAL_SIZE') 

        // This order suits the best for forum* content types but it's also 
        // OK for news and flights where created_at and updated_at
        // timestaps are usually same (or differ just a little)

        Content::orderBy('updated_at', 'desc')->chunk($chunkSize, function ($content) use (&$count, $chunkCount, $progress) {
            $content->each(function ($content) use ($progress) {
                $this->generateKeywords($content);
                $progress->advance();
            });
            $count++;
            if ($count >= $chunkCount) {
                return false;
            }
        });

        $this->info("\n\nDone\n");
    }

    protected function cleanupMeta()
    {
        $keys = Content::whereNotNull('meta')->pluck('id');
        $keys->chunk($this->chunkSize)->each(function ($chunk) {
            Content::whereIn('id', $chunk)->each(function ($content) {
                $content->meta = null;
                $content->timestamps = false;
                $content->save();
            });
        });
    }

    protected function generateKeywords($content)
    {
        $tokens = $this->getTokens(
            $content->title.' '.$content->body
        );
        $keywords = $this
            ->getKeywords($tokens)
            ->pipe(function ($keywords) use ($content) {
                return $this->getManualKeywords($keywords, $content);
            })
            ->pipe(function ($keywords) {
                return $this->getParentKeywords($keywords);
            })
            ->pipe(function ($keywords) {
                return $this->cleanupKeywords($keywords);
            })
            ->values();

        if ($keywords) {
            $content['meta->keywords'] = $keywords;
            $content->timestamps = false;
            $content->save();
        }
    }

    protected function getTokens($text)
    {
        // We tokenize the content title and body
        // by first replacing all the punctuation
        // with spaces and then split the string into
        // array by space

        $pattern = "/[\.\,\:\;\-\(\)\*\!\?\s+\\n\r]/";

        $splitText = collect(preg_split($pattern, $text))
            ->reject(function ($token) {
                return empty($token);
            })
            ->values();

        return $splitText
            ->map(function ($token, $index) use ($splitText) {
                $string = clone $splitText;
                return [
                    'token' => $token,
                    // For keywords containg spaces (Saudi Araabia etc)
                    // we keep also the token doubles
                    'token_double' => $string->splice($index, 2),
                ];
            })
            // Find destinations
            ->map(function ($token) {
                $match = $this->destinations
                    ->filter(function ($destination) use ($token) {
                        $destination = collect(explode(' ', $destination))
                            ->take(2)
                            ->implode('');

                        return preg_match(
                            '/^'.$destination.'/',
                            $token['token_double']->implode('')
                        );
                    });
                if ($match->isNotEmpty()) {
                    $token['match'] = $match->first();
                    $token['type'] = 'destination';
                }

                return $token;
            })
            // Find topics
            ->map(function ($token) {
                $match = $this->topics
                    ->filter(function ($topic) use ($token) {
                        return preg_match('/^'.$topic.'/i', $token['token']);
                    });
                if ($match->isNotEmpty()) {
                    $token['match'] = $match->first();
                    $token['type'] = 'topic';
                }

                return $token;
            })
            // Find carriers
            ->map(function ($token) {
                $match = $this->carriers
                    ->filter(function ($carrier) use ($token) {
                        return preg_match('/^'.$carrier.'/i', $token['token']);
                    });
                if ($match->isNotEmpty()) {
                    $token['match'] = $match->first();
                    $token['type'] = 'carrier';
                }

                return $token;
            });
    }

    protected function getKeywords($tokens)
    {
        return $tokens
            ->filter(function ($token) {
                return array_key_exists('match', $token);
            })
            ->map(function ($token, $index) use ($tokens) {
                $token['score'] = $this->calculateDecay($index, $tokens->count() - 1);

                return $token;
            })
            ->groupBy(function ($token) {
                return $token['match'];
            })
            ->map(function ($tokens, $keyword) {
                return [
                    'name' => $keyword,
                    // Score is the highest score among
                    // all keyword ocurrences in text
                    // TODO: Consider also the number of occurrences:
                    //   'countScore' => min([$tokens->count() * 0.34, 1])
                    'score' => $tokens->max(function ($token) {
                        return $token['score'];
                    }),
                    'type' => $tokens->pluck('type')->first(),
                ];
            });
    }

    protected function getManualKeywords($keywords, $content)
    {
        return $keywords
            ->merge($content->topics
                ->map(function ($topic) {
                    return [
                        'name' => $topic->name,
                        'score' => 0.6,
                        'type' => 'topic',
                        'manual' => true,
                    ];
                })
            )
            ->merge($content->destinations
                ->map(function ($destination) {
                    return [
                        'name' => $destination->name,
                        //'score' => ($destination->depth + 1) * 0.33,
                        'score' => 1,
                        'type' => 'destination',
                        'manual' => true,
                    ];
                })
            );
    }

    protected function getParentKeywords($keywords)
    {
        $parents = collect();

        $keywords->each(function ($keyword) use (&$parents) {
            $destination = Destination::whereName($keyword['name'])->first();
            if ($destination) {
                $parent = Destination::find($destination->parent_id);
                if (
                    $parent
                    && ! in_array(
                        $parent->name,
                        config('similars.destination.parentfilter')
                    )
                ) {
                    $parents->push([
                        'name' => $parent->name,
                        'score' => ($parent->depth + 1) * 0.33,
                        'type' => 'destination',
                        'parent' => true,
                    ]);
                }
            }
        });

        return $parents->isNotEmpty() ? $keywords->merge($parents) : $keywords;
    }

    protected function cleanupKeywords($keywords)
    {
        return $keywords
            //->sortByDesc('score')
            //->unique('name')
            //->keyBy('name')
            // ->map(function($keyword) {
            //     unset($keyword['name']);
            //     return $keyword;
            // })
;
    }

    public function calculateDecay($value, $sourceMax, $floor = 0.1, $ceil = 0.9)
    {
        $scaledSourceValue = $this->scale($value, 0, $sourceMax, 0, 1);
        $decay = pow($scaledSourceValue - 1, 4);
        $scaledTargetValue = $this->scale($decay, 0, 1, $floor, $ceil);

        return round($scaledTargetValue, 3);
    }

    public function scale($value, $sourceMin, $sourceMax, $targetMin, $targetMax)
    {
        // See https://stats.stackexchange.com/a/70808
        if ($sourceMax - $sourceMin == 0) {
            return $value;
        }

        return ($targetMax - $targetMin)
            / ($sourceMax - $sourceMin)
            * ($value - $sourceMin)
            + $targetMin;
    }

    protected function getDestinations()
    {
        return Destination::pluck('name')
            ->filter(function ($destination) {
                return ! in_array($destination, [
                    config('similars.destination.filter'),
                ]);
            })
            ->merge(config('similars.destination.add'));
    }

    protected function getTopics()
    {
        return Topic::pluck('name')
            ->filter(function ($topic) {
                return ! in_array($topic, [
                    config('similars.topic.filter'),
                ]);
            })
            ->merge(config('similars.topic.add'));
    }

    protected function getCarriers()
    {
        return Carrier::pluck('name')
            ->filter(function ($topic) {
                return ! in_array($topic, [
                    config('similars.carrier.filter'),
                ]);
            })
            ->merge(config('similars.carrier.add'));
    }
}
