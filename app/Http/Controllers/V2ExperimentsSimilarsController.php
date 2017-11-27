<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;
use App\Topic;
use App\Carrier;
use App\Comment;

class V2ExperimentsSimilarsController extends Controller
{
    public function index()
    {
        $contents = Content::orderBy('updated_at', 'desc')
            ->take(10)
            ->skip(request()->get('skip', 0))
            ->whereType(request()->get('type', 'forum'))
            ->get();

        return response(
            $this->Html($this->Heading().$contents->map(function($c) {
                return $this->Content($c);
            })->implode(''))
        );

    }

    public function Html($body) {
        return <<<C
            <html>
                <head>
                <meta charset="UTF-8">
                <link href="https://fonts.googleapis.com/css?family=Cousine|400,400i,700,700i" rel="stylesheet">
                <style>
                    body {
                        font-family: 'Cousine', monospace;
                        margin: 2rem;
                        line-height: 1.75em;
                        font-size: 0.75em;
                    }
                    a {
                        color: inherit;
                    }
                    .destination {
                        background: rgba(255,255,200,1);
                        color: rgba(0,0,0,0.9);
                        border-radius: 2px;
                        padding: 2px;
                    }
                    .manu {
                        border-left: 3px solid rgba(200,0,100,0.6);
                    }
                    .manu .destination {
                        padding-left: 5px;
                    }
                    .destination.light {
                        background: rgba(255,255,200,0.5);
                    }
                    .topic {
                        background: rgba(200,255,200,0.6);
                        color: rgba(0,0,0,0.9);
                        padding: 2px;
                        border-radius: 2px;
                    }
                    .destination.light {
                        background: rgba(200,255,200,0.3);
                    }
                    .carrier {
                        background: rgba(100,200,200,0.3);
                        color: rgba(0,0,0,0.9);
                        padding: 2px;
                        border-radius: 2px;
                    }
                    .carrier.light {
                        background: rgba(100,200,200,0.1);
                    }
                    .manual {
                        color: rgba(200,0,100,0.7);
                        font-style: normal;
                        border-left: 3px solid rgba(200,0,100,0.6);
                        padding-left: 3px;
                        margin-left: -6px;
                    }
                    .parent {
                        color: rgba(150,0,150,1);
                        font-style: normal;
                    }
                    .type {
                        color: rgba(14,177,250,0.7);
                    }
                    .subtle {
                        opacity: 0.5;
                    }
                </style>
                </head>
                <body>
                    $body
                </body>
            </head>
C;
    }

    function Content($content) {
        
        $text = $this->Text($content);
        $keywords = $this->Keywords(collect($content->meta['keywords']));
        
        $similarsForum = '';
        $similarsNews = '';
        $similarsFlight = '';

        if ($content->meta && array_key_exists('similars', $content->meta)) {
            $similarsForum = $this->Similars(
                collect($content->meta['similars'])->only('forum'),
                collect($content->meta['keywords'])
            );
            $similarsNews = $this->Similars(
                collect($content->meta['similars'])->only('news'),
                collect($content->meta['keywords'])
            );
            $similarsFlight = $this->Similars(
                collect($content->meta['similars'])->only('flight'),
                collect($content->meta['keywords'])
            );
        }

        return <<<C
            <div style="
                display: grid;
                grid-template-columns: repeat(5, 20%);
                grid-gap: 1.5rem;
                padding-bottom: 2rem;
                margin-bottom: 2rem;
                border-bottom: 1px solid rgba(0,0,0,0.2);
            ">
                <div>$text</div>
                <div style="background: rgba(0,0,0,0.05); padding: 1rem;">$keywords</div>
                <div>$similarsForum</div>
                <div>$similarsFlight</div>
                <div>$similarsNews</div>
            </div>
C;
    }

        public function Heading()
        {
            $skip = request()->get('skip', 0);
            $nextSkip = $skip + 100;

            $type = request()->get('type', 'forum');

            $heading = collect(['forum', 'flight', 'news'])
                ->map(function($type) use ($skip) {
                    return "<a href=\"?type=$type&skip=$skip\">$type</a>";
                })->implode(' ');

            $heading .= "&nbsp;&nbsp;&nbsp;<a href=\"?type=$type&skip={$nextSkip}\">Next →</a>";

            return <<<C
                <div style="
                    color: rgba(0,0,0,0.7);
                    margin-bottom: 1rem;
                ">$heading</div>
                <div style="
                    display: grid;
                    grid-template-columns: 20% 20% 50%;
                    grid-gap: 1.5rem;
                    padding-bottom: 1rem;
                    margin-bottom: 2rem;
                    border-bottom: 1px solid rgba(0,0,0,0.2);
                    color: rgba(0,0,0,0.5);
                ">
                    <div>
                        Content
                        <div class="subtle">
                            Filtered by type, ordered by last modified date
                        </div>
                    </div>
                    <div>
                        Keywords
                        <div class="subtle">
                            1. Keywords are searched inside title and body of the content. They ordered and scored by occurrence (keywords in beginning of text are scored higher)
                            <br>
                            2. Manual keywords (set by user or editor) are added to the keywords
                            <br>
                            3. Destination parents are added to the keywords
                        </div>
                    </div>
                    <div>
                        Similars
                        <div class="subtle">
                        1. Content keywords are filtered so the lowest scored keywords are not used
                        <br>
                        2. Content keywords are compared with other recently modified content keywords. 
                        <br>
                        3. If there is a keyword overlap (intersection), we have some similar content. 
                        <br>
                        4. The more there is a keyword overlap, the larger is the score. Destination overlaps are prioritized over topic overlaps.
                        <br>
                        5. The comparision process is repeated until we have enough similar content with high enough score for each content type 
                        </div>
                    </div>

                </div>
C;
        }

    public function Text($content)
    {
        $keywords = collect($content->meta['keywords']);
        $body = strip_tags($content->body);
        $tags = $content->destinations->pluck('name')
                ->merge($content->topics->pluck('name'))
                ->map(function($tag) {
                    return "<span class=\"manu\">$tag</span>";
                })
                ->implode(' ');

        $output = <<<C
            <span class="type">$content->type</span>
            <br>
            <div class="subtle">{$content->created_at->diffForHumans()}
             / {$content->updated_at->diffForHumans()}
             </div>
            <br>
            <b>$content->title</b>
            <br>
            <br>
            $body
            <br>
            <br>
            $tags
            <p />
C;
        
        collect(['destination','topic','carrier'])
            ->each(function($type) use ($keywords, &$output) {
                $typeKeywords = $keywords->filter(function($d) use ($type) {
                    return $d['type'] == $type;
                });
                if ($typeKeywords->isNotEmpty()) {
                    $case = ($type == 'topic') ? 'i' : '';
                    $output = preg_replace(
                        "/("
                            .$typeKeywords->pluck('name')->implode('|')
                        .")/m$case",
                        "<span class=\"$type\">$1</span>",
                        $output
                    );
                }
        });
           
        return <<<C
            <div style="
                overflow: scroll;
                color: rgba(0,0,0,0.7);
                padding-right: 1.5rem;
            ">$output</div>
C;
    }

    public function Keywords($keywords) {

        $output = $keywords->toJson(JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        $output = preg_replace('/^(  +?)\\1(?=[^ ])/m', '$1', $output);
        $output = str_replace('  ', ' ', $output);

        collect(['destination','topic','carrier'])->each(function($type)
            use ($keywords, &$output) {
            
            $typeKeywords = $keywords->filter(function($d) use ($type) {
                return $d['type'] == $type;
            });
            if ($typeKeywords->isNotEmpty()) {
                $output = preg_replace(
                    "/("
                        .$typeKeywords->pluck('name')->implode('|')
                    .")/m",
                    "<span class=\"$type\">$1</span>",
                    $output
                );
            }
        });

        $output = preg_replace("/(\"manual\":\strue)/m", "<span class=manual>$1</span>", $output);
        $output = preg_replace("/(parent\":\strue)/m", "<span class=parent>$1</span>", $output);

        return <<<C
            <div style="
                white-space: pre-wrap;
                word-wrap: normal;
                line-height: 1.25rem;
                color: rgba(0,0,0,0.65);
            ">$output</div>
C;
    }

    public function Similars($data, $keywords) {
        
        $output = $data->toJson(JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        $output = preg_replace('/^(  +?)\\1(?=[^ ])/m', '$1', $output);
        $output = str_replace('  ', ' ', $output);

        collect(['destination','topic','carrier'])->each(function($type) use ($keywords, &$output) {
            $typeKeywords = $keywords->filter(function($d) use ($type) {
                return $d['type'] == $type;
            });
            if ($typeKeywords->isNotEmpty()) {
                $output = preg_replace(
                    "/("
                        .$typeKeywords->pluck('name')->implode('|')
                    .")/m",
                    "<span class=\"$type light\">$1</span>",
                    $output
                );
            }
        });

        $output = preg_replace("/(\"manual\":\strue)/m", "<span class=manual>$1</span>", $output);
        $output = preg_replace("/(parent\":\strue)/m", "<span class=parent>$1</span>", $output);
        $output = preg_replace("/(title\":\s.*\")/m", "<span style=\"color:black; text-decoration: none;\">$1</span>", $output);
        $output = preg_replace("/(forum|news|flight)/m", "<span class=type>$1</span>", $output);

        $output = preg_replace(
            "/("
            .$keywords->filter(function($d) {
                    return $d['type'] == 'destination';
                })
                ->pluck('name')
                ->implode('|')
            .")/m",
            "<span class=\"destination\">$1</span>",
            $output
        );
        return <<<C
            <div style="
                white-space: pre-wrap;
                word-wrap: normal;
                overflow-wrap: break-word;
                line-height: 1.25rem;
                -overflow: scroll;
                color: rgba(0,0,0,0.65);
            ">$output</div>
C;
    }

}