<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Content;
use App\Destination;
use App\Topic;
use App\Carrier;

class GenerateKeywords extends Command
{

    protected $signature = 'generate:keywords';

    protected $destinations;
    protected $topics;
    protected $carriers;

    public function __construct()
    {
        parent::__construct();

        $this->destinations = Destination::pluck('name')
            ->filter(function($destination) {
                return !in_array($destination, [
                    'Eesti', 'Tallinn', 'Pai', 'Are', 'Euroopa'
                ]);
            })
            ->merge([
                // Misspellings
                'Niagra',
                'Maroco',
                'Qatar',
                // Additions
                'Douro',
                'Las Palmas',
                'Los Gigantes',
                'Krabi',
                'Sharm',
                'Mekong',
                'Busuanga',
                'Panglao',
                'Serengeti',
                'Vantaa',
                'Caymani saared',
                'Fort Lauderdale',
                'Warsaw',
                'Phi Phi',
                'Belek',
                'Nassau',
                'Pokhara',
                'Yukatan',
                'Stansted',
                'Gatwick',
                'Doha'
            ])
        ;

        $this->topics = Topic::pluck('name')
            ->filter(function($topic) {
                return !in_array($topic, [
                    'Töö'
                ]);
            })
            ->merge([
                'Päike',
                'Alkohol',
                'Voodi',
                'Beebi',
                'Shoppam',
                'Majutus',
                'Hotell',
                'Apartment',
                'Vaktsi',
                'Vaksi',
                'Viisa',
                'Söök',
                'Autoren',
                'Lennujaam',
                'Safari',
                'Lapse',
                'Rannapuhkus',
                'Passi',
                'Lennupilet',
                'Krediitkaart',
                'Pangakaart',
                'Juhilu',
                'Juhilo',
            ])
        ;
        $this->carriers = Carrier::pluck('name')
            ->filter(function($topic) {
                return !in_array($topic, [
                    'Delta'
                ]);
            })
            ->merge([
                'Wizzair',
                'Aeromexico',
                'Ethiopian Airlines',
                'Expedia',
                'Novatours',
                'Albamare',
                'Airbnb',
                'Eckerö Line'

            ])
        ;
    }

    public function handle()
    {
        $maxCount = 100;
        $chunkSize = 10;
        $chunkCount = $maxCount / $chunkSize;

        $count = 0;

        $progress = $this->output->createProgressBar($maxCount);

        $this->info("\nGenerating keywords\n");

        Content::orderBy('updated_at', 'desc')->chunk($chunkSize, function($content)
            use (&$count, $chunkCount, $progress) {
                $content->each(function($content) use ($progress) {
                    $this->generateKeywords($content);
                    $progress->advance();
                });
                $count++;
                if ($count >= $chunkCount) return false;
            });

        $this->info("\n\nDone\n");

    }

    protected function generateKeywords($content) {
        $tokens = $this->getTokens(
            $content->title.' '.$content->body
        );
        $keywords = $this
            ->getKeywords($tokens)
            ->pipe(function($keywords) use ($content) {
                return $this->getManualKeywords($keywords, $content);
            })
            ->pipe(function($keywords) {
                return $this->getParentKeywords($keywords);
            })
            ->pipe(function($keywords) {
                return $this->cleanupKeywords($keywords);
            })
            ->values()
        ;

        if ($keywords) {
            // $this->line($keywords->toJSON(JSON_PRETTY_PRINT));
            $content['meta->keywords'] = $keywords;
            $content->timestamps = false;
            $content->save();
        }
    }

    protected function getTokens($text)
    {
        
        $pattern = "/[\.\,\:\;\-\(\)\*\!\?\s+\\n\r]/";
        
        $splitText = collect(preg_split($pattern, $text))
            ->reject(function($token) { return empty($token); })
            ->values();

        return $splitText
            ->map(function($token, $index) use ($splitText) {
                $string = clone $splitText;
                return [
                    'token' => $token,
                    'token_double' => $string->splice($index, 2)
                ];
            })
            ->map(function($token) {
                $match = $this->destinations
                    ->filter(function($destination) use ($token) {
                        $destination = collect(explode(' ', $destination))
                            ->take(2)
                            ->implode('');
                        return preg_match(
                            "/^".$destination."/",
                            $token['token_double']->implode('')
                        );
                    });
                if ($match->isNotEmpty()) {
                    $token['match'] = $match->first();
                    $token['type'] = 'destination';
                }
                return $token;
            })
            ->map(function($token) {
                $match = $this->topics
                    ->filter(function($topic) use ($token) {
                        return preg_match("/^".$topic."/i", $token['token']);
                    });
                if ($match->isNotEmpty()) {
                    $token['match'] = $match->first();
                    $token['type'] = 'topic';
                }
                return $token;
            })
            ->map(function($token) {
                $match = $this->carriers
                    ->filter(function($carrier) use ($token) {
                        return preg_match("/^".$carrier."/i", $token['token']);
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
            ->filter(function($token) {
                return array_key_exists('match', $token);
            })
            ->map(function($token, $index) use ($tokens) {
                $token['score'] = $this->calculateDecay($index, $tokens->count() - 1);
                return $token;
            })
            ->groupBy(function($token) {
                return $token['match'];
            })
            ->map(function($tokens, $keyword) {
                return [
                    'name' => $keyword,
                    // Score is the highest score among 
                    // all keyword ocurrences in text
                    // TODO: Consider also the number of occurrences:
                    //   'countScore' => min([$tokens->count() * 0.34, 1])
                    'score' => $tokens->max(function($token) {
                        return $token['score'];
                    }),
                    'type' => $tokens->pluck('type')->first()
                ];
            });
    }

    protected function getManualKeywords($keywords, $content)
    {
        return $keywords
            ->merge($content->topics
                ->map(function($topic) {
                    return [
                        'name' => $topic->name,
                        'score' => 0.6,
                        'type' => 'topic',
                        'manual' => true,
                    ];
                })
            )
            ->merge($content->destinations
                ->map(function($destination) {
                    return [
                        'name' => $destination->name,
                        //'score' => ($destination->depth + 1) * 0.33,
                        'score' => 1,
                        'type' => 'destination',
                        'manual' => true
                    ];
                })
            )
        ;
    }

    protected function getParentKeywords($keywords)
    {
        $parents = collect();

        $keywords->each(function($keyword) use (&$parents) {
            $destination = Destination::whereName($keyword['name'])->first();
            if ($destination) {
                $parent = Destination::find($destination->parent_id);
                if (
                    $parent
                    && !in_array($parent->name, ['Euroopa', 'Aasia'])
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

    public function calculateDecay($value, $sourceMax, $floor = 0.1, $ceil = 0.9) {
        
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
        return ($targetMax -$targetMin)
            / ($sourceMax - $sourceMin)
            * ($value - $sourceMin)
            + $targetMin;
    }
    
}
