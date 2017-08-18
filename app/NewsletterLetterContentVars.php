<?php

namespace App;

use DB;
use Exception;

class NewsletterLetterContentVars
{
    protected $item;
    protected $tags;
    protected $temp_body;

    protected $allowed_order_by_columns = [
        'id',
        'pop',
        'updated_at',
        'created_at',
    ];

    protected $allowed_order_by_options = [
        'asc',
        'desc',
    ];

    protected $allowed_types = [
        'flight',
        'forum',
        'buysell',
        'expat',
        'travelmate',
        'news',
        'shortnews',
    ];

    public function __construct(NewsletterLetterContent $item)
    {
        $this->item = $item;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        $message = '%s does not respond to the "%s" property or method.';

        throw new Exception(
            sprintf($message, static::class, $property)
        );
    }

    public function compose(Content $the_flight = null, NewsletterType $newsletterType = null)
    {
        $this->temp_body = $this->item->body;
        $matches = [];
        $pattern = '#\[\[(.*?)\]\]#';

        preg_match_all($pattern, $this->temp_body, $matches);

        if (count($matches)) {
            foreach ($matches[1] as &$tags) {
                $this->tags = mb_strtolower($tags);

                $this->replace_if_matches($the_flight, $newsletterType);
            }
        }

        return $this->temp_body;
    }

    protected function replace_if_matches(Content $the_flight = null, NewsletterType $newsletterType = null)
    {
        $contents = null;
        $sql_options = [
            'where' => [],
        ];
        $skip_element = true;
        $content = '';

        if ($this->tags == 'the_flight') {
            $skip_element = false;

            if (! $the_flight) {
                $sql_options['order_by'] = [
                    'column' => 'RAND()',
                ];
                $sql_options['take'] = 1;
            } else {
                $contents = $the_flight;
            }
        } else {
            foreach (['type', 'take', 'skip', 'order_by'] as $type) {
                if (strpos($this->tags, $type.':') !== false) {
                    $column_values = trim(explode($type.':', $this->tags)[1]);

                    if (strpos($column_values, '|') !== false) {
                        $column_values = trim(explode('|', $column_values)[0]);
                    }

                    if ($type == 'type') {
                        if (strpos($column_values, ',') !== false) {
                            $col_values = explode(',', $column_values);

                            $column_values = [];
                            foreach ($col_values as &$column_value) {
                                if (trim($column_value) != '' && in_array($column_value, $this->allowed_types)) {
                                    $column_values[] = $column_value;
                                }
                            }

                            if (count($column_values)) {
                                $sql_options['where']['type'] = $column_values;
                                $skip_element = false;
                            }
                        } elseif ($column_values != '') {
                            $sql_options['where']['type'] = $column_values;
                            $skip_element = false;
                        }
                    } elseif (($type == 'take' || $type == 'skip') && strpos($column_values, ',') === false && is_numeric($column_values) && (int) $column_values > 0) {
                        $sql_options[$type] = (int) $column_values;

                        if ($type == 'take') {
                            $skip_element = false;
                        }
                    } elseif ($type == 'order_by') {
                        if (strpos($column_values, ',') !== false) {
                            $sort_order = explode(',', $column_values);

                            if (count($sort_order) == 2) {
                                $order_by_column = trim($sort_order[0]);
                                $order_by_option = trim($sort_order[1]);

                                if (in_array($order_by_column, $this->allowed_order_by_columns)) {
                                    $sql_options['order_by'] = [
                                        'column' => $order_by_column,
                                        'option' => 'desc',
                                    ];

                                    if (in_array($order_by_option, $this->allowed_order_by_options)) {
                                        $sql_options['order_by']['option'] = $order_by_option;
                                    }
                                }
                            }
                        } else {
                            if (in_array($column_values, $this->allowed_order_by_columns)) {
                                $sql_options['order_by'] = [
                                    'column' => $column_values,
                                    'option' => 'desc',
                                ];
                            }
                        }
                    }
                }
            }

            if (! isset($sql_options['order_by'])) {
                $sql_options['order_by'] = [
                    'column' => 'created_at',
                    'option' => 'desc',
                ];
            }
        }

        if ($skip_element) {
            $this->temp_body = str_replace('[['.$this->tags.']]', '', $this->temp_body);
        } else {
            if ($contents) {
                $image = $contents->imagePreset('small_fit');
                $content .= mail_component('mail::flight', [
                    'image' => (filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image)),
                    'url' => route('flight.show', $contents->slug),
                    'button_color' => 'green',
                    'slot' => $contents->vars()->title,
                ]);
            } elseif (isset($sql_options['where']) && count($sql_options['where'])) {
                $contents = Content::with([
                    'images',
                    'user',
                    'user.images',
                    'destinations',
                    'topics',
                ])->where('status', 1);
                $check_contents = Content::with([
                    'images',
                    'user',
                    'user.images',
                    'destinations',
                    'topics',
                ])->where('status', 1);

                if (isset($sql_options['where']) && count($sql_options['where'])) {
                    foreach ($sql_options['where'] as $column_name => &$value) {
                        if (is_array($value)) {
                            $contents = $contents->whereIn($column_name, $value);
                            $check_contents = $check_contents->whereIn($column_name, $value);
                        } else {
                            $contents = $contents->where($column_name, $value);
                            $check_contents = $check_contents->where($column_name, $value);
                        }
                    }
                }

                if (isset($sql_options['skip'])) {
                    $contents = $contents->skip($sql_options['skip']);
                    $check_contents = $check_contents->skip($sql_options['skip']);
                }

                if (isset($sql_options['take'])) {
                    $contents = $contents->take($sql_options['take']);
                    $check_contents = $check_contents->take($sql_options['take']);
                }

                if (isset($sql_options['order_by']) && isset($sql_options['order_by']['column']) && isset($sql_options['order_by']['option'])) {
                    if ($sql_options['order_by']['column'] == 'pop') {
                        if ($newsletterType && $newsletterType->send_days_after) {
                            $interval = $newsletterType->send_days_after;
                        } else {
                            $interval = 30;
                        }

                        $check_contents = $check_contents
                            ->select([
                                'contents.*',
                                DB::raw('(SELECT COUNT(*) FROM comments WHERE content_id = contents.id) AS comments_count'),
                            ])
                            ->where('updated_at', '>', DB::raw('(NOW() - INTERVAL '.$interval.' DAY)'))
                            ->orderBy('comments_count', $sql_options['order_by']['option']);

                        if (! $check_contents->count()) {
                            $contents = $contents
                                ->orderBy('created_at', 'desc');
                        } else {
                            $contents = $check_contents;
                        }
                    } else {
                        $contents = $contents->orderBy($sql_options['order_by']['column'], $sql_options['order_by']['option']);
                    }
                }

                $contents = $contents->get();

                $flights_count = 0;

                foreach ($contents as &$item) {
                    if ($item->type == 'flight') {
                        if ($flights_count > 2) {
                            $flights_count = 0;
                        }

                        $image = $item->imagePreset('small_fit');
                        $content .= mail_component('mail::flight', [
                            'image' => (filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image)),
                            'url' => route('flight.show', $item->slug),
                            'button_color' => ['blue', 'red', 'green'][$flights_count],
                            'slot' => $item->vars()->title,
                        ]);

                        ++$flights_count;
                    } elseif (in_array($item->type, ['news', 'shortnews'])) {
                        $image = $item->imagePreset('small_fit');
                        $content .= mail_component('mail::news', [
                            'image' => (filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image)),
                            'date' => $item->vars()->created_at,
                            'url' => route($item->type.'.show', [$item->slug]),
                            'slot' => $item->vars()->title,
                        ]);
                    } elseif (in_array($item->type, ['forum', 'buysell', 'expat', 'travelmate'])) {
                        $destinations = [];
                        if ($item->destinations && $item->destinations->count()) {
                            foreach ($item->destinations as &$destination) {
                                $destinations[] = [
                                    'name' => $destination->name,
                                    'url' => route('destination.showSlug', [$destination->slug]),
                                ];
                            }
                        }

                        $topics = [];
                        if ($item->topics && $item->topics->count()) {
                            foreach ($item->topics as &$topic) {
                                $topics[] = [
                                    'name' => $topic->name,
                                    'url' => route('forum.index', ['topic' => $topic]),
                                ];
                            }
                        }

                        $user_image = $item->user->imagePreset('small_square');

                        if (strpos($user_image, '.svg') !== false) {
                            $pos = (int) round(mb_strlen($user_image) - strrpos($user_image, '.svg') - 4);

                            if ($pos == 0) {
                                $user_image = null;
                            }
                        }

                        $content .= mail_component('mail::list', [
                            'image' => (filter_var($user_image, FILTER_VALIDATE_URL) ? $user_image : ($user_image ? asset($user_image) : null)),
                            'user' => $item->user->name,
                            'slot' => $item->vars()->title,
                            'destinations' => (count($destinations) ? $destinations : null),
                            'topics' => (count($topics) ? $topics : null),
                            'url' => route($item->type.'.show', [$item->slug]),
                        ]);
                    }
                }
            }

            $this->temp_body = str_replace('[['.$this->tags.']]', $content, $this->temp_body);
        }
    }
}
