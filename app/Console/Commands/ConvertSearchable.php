<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Searchable;
use DB;

class ConvertSearchable extends Command
{
    protected $signature = 'search:index';

    /*
     * Most places we use app('db')->select(..) to avoid Laravel eloquent because it increases processing time
     */

    public function handle()
    {
        $start = microtime(true);

        $search_indexes = Searchable::select([
            'id',
            'user_id',
            'content_id',
            'comment_id',
            'destination_id',
            'title',
            'body',
            'created_at',
        ])->orderBy('id', 'asc');

        $index_fields = [];

        $users = $this->get_users_for_index($index_fields);
        $user_ids = $this->get_object_ids($users);

        $content_type_by_id = [];
        $contents = $this->get_content_for_index($index_fields, $content_type_by_id);
        $content_ids = $this->get_object_ids($contents);

        $this->get_comments_for_index($index_fields, $content_ids, $user_ids, $content_type_by_id, true);

        $this->get_destinations_for_index($index_fields, true);

        $delete_ids = [];

        $this->line(' - 1/2 Comparing data with search index');
        $search_indexes->chunk(2500, function ($indexes) use (&$index_fields, &$delete_ids) {
            foreach ($indexes as &$index)
            {
                if ($index->comment_id) {
                    $key = 'cc' . $index->comment_id;
                } elseif ($index->content_id) {
                    $key = 'c' . $index->content_id;
                } elseif ($index->destination_id) {
                    $key = 'd' . $index->destination_id;
                } elseif ($index->user_id) {
                    $key = 'u' . $index->user_id;
                } else {
                    $key = null;
                }

                if ($key && isset($index_fields[$key])) {
                    if (! $index->title) {
                        $index->title = 'null';
                    } else {
                        $index->title = DB::getPdo()->quote($index->title);
                    }

                    if (! $index->body) {
                        $index->body = 'null';
                    } else {
                        $index->body = DB::getPdo()->quote($index->body);
                    }

                    if ($index->title == $index_fields[$key]['title'] && $index->body == $index_fields[$key]['body']) {
                        unset($index_fields[$key]);
                    } else {
                        $index_fields[$key]['id'] = (int) $index->id;
                        $index_fields[$key]['created_at'] = DB::getPdo()->quote($index->created_at);
                    }
                } else {
                    $delete_ids[] = $index->id;
                }
            }
        });

        $this->info(' + 2/2 Comparing completed!');
        $count_delete_ids = count($delete_ids);
        if ($count_delete_ids > 0) {
            Searchable::destroy($delete_ids);
            $this->error(' + ' . count($delete_ids) . ' items deleted from search index');
        } else {
            $this->info(' + 0 items deleted from search index');
        }

        $index_count = count($index_fields);
        if ($index_count > 0) {
            $this->save($index_fields, $index_count);
        } else {
            $this->info(' + Nothing to save');
        }

        $this->info('Command finished after ' . round(microtime(true) - $start, 4).' seconds');
    }

    public function save(array $items, int $index_count)
    {
        $this->line(' - 1/3 Preparation for save ('.$index_count.' items)...');

        $replace_insert = 'REPLACE INTO `searchables` (`id`, `user_id`, `content_id`, `content_type`, `comment_id`, `destination_id`, `title`, `body`, `updated_at`, `created_at`)';
        $items_done = 0;
        $last_round = 0;
        foreach (array_chunk($items, 100) as &$chucked_items)
        {
            $data = [];
            foreach ($chucked_items as &$item)
            {
                ++$items_done;
                ++$last_round;
                $data[] = '(' . implode(', ', $item) . ')';
            }

            app('db')->select($replace_insert . ' VALUES ' . implode(', ', $data));

            if ($last_round === 2500) {
                $last_round = 0;
                $this->info(' - '.$items_done.' / '.$index_count.' ('.round($items_done * 100 / $index_count, 2).'%) items saved');
            } elseif ($items_done == $index_count) {
                $this->info(' + '.$items_done.' / '.$index_count.' (100%) items saved');
            }
        }
    }

    public function get_users_for_index(&$index_fields, $void_return = false)
    {
        $this->line(' - 1/3 Fetching users from database...');
        $users = app('db')->select('SELECT `id`, `name` FROM `users` WHERE `verified` = 1 ORDER BY `id` ASC');

        $this->line(' - 2/3 Adding users to index array...');
        foreach ($users as &$user)
        {
            if (! $user->name || $user->name == '') {
                $user->name = null;
            }

            if ($user->name) {
                $index_fields['u' . $user->id] = [
                    'id' => 'null',
                    'user_id' => (int) $user->id,
                    'content_id' => 'null',
                    'content_type' => 'null',
                    'comment_id' => 'null',
                    'destination_id' => 'null',
                    'title' => DB::getPdo()->quote($this->safe($user->name)),
                    'body' => 'null',
                    'updated_at' => 'NOW()',
                    'created_at' => 'NOW()',
                ];
            }
        }
        $this->info(' + 3/3 Users are ready');

        if (! $void_return) {
            return $users;
        }
    }

    public function get_content_for_index(&$index_fields, &$content_type_by_id, $void_return = false)
    {
        $this->line(' - 1/3 Fetching contents from database...');
        $contents = app('db')->select('SELECT `id`, `user_id`, `title`, `type`, `body`, `url`, `price` FROM `contents` WHERE `status` = 1 ORDER BY `id` ASC');

        $this->line(' - 2/3 Adding contents to index array...');
        foreach ($contents as &$content)
        {
            if (! $content->title || $content->title == '') {
                $content->title = null;
            }

            $body = trim($content->url . "\n" . $content->price . "\n" . $content->body);

            if (! $body || $body == '') {
                $body = null;
            }

            $index_fields['c' . $content->id] = [
                'id' => 'null',
                'user_id' => (int) $content->user_id,
                'content_id' => (int) $content->id,
                'content_type' => DB::getPdo()->quote($content->type),
                'comment_id' => 'null',
                'destination_id' => 'null',
                'title' => ($content->title ? DB::getPdo()->quote($this->safe($content->title)) : 'null'),
                'body' => ($body ? DB::getPdo()->quote($this->safe($body)) : 'null'),
                'updated_at' => 'NOW()',
                'created_at' => 'NOW()',
            ];

            $content_type_by_id[$content->id] = $content->type;
        }
        $this->info(' + 3/3 Contents are ready');

        if (! $void_return) {
            return $contents;
        }
    }

    public function get_destinations_for_index(&$index_fields, $void_return = false)
    {
        $this->line(' - 1/3 Fetching destinations from database...');
        $destinations = app('db')->select('SELECT `id`, `name` FROM `destinations` ORDER BY `id` ASC');

        $this->line(' - 2/3 Adding destinations to index array...');
        foreach ($destinations as &$destination)
        {
            $index_fields['d' . $destination->id] = [
                'id' => 'null',
                'user_id' => 'null',
                'content_id' => 'null',
                'content_type' => 'null',
                'comment_id' => 'null',
                'destination_id' => (int) $destination->id,
                'title' => DB::getPdo()->quote($this->safe($destination->name)),
                'body' => 'null',
                'updated_at' => 'NOW()',
                'created_at' => 'NOW()',
            ];
        }
        $this->info(' + 3/3 Destinations are ready');

        if (! $void_return) {
            return $destinations;
        }
    }

    public function get_comments_for_index(&$index_fields, $content_ids, $user_ids, $content_type_by_id, $void_return = false)
    {
        $this->line(' - 1/3 Fetching comments from database...');
        $comments = app('db')->select('SELECT `id`, `user_id`, `content_id`, `body` FROM `comments` WHERE `status` = 1 AND (`content_id` IN ('.implode(',', $content_ids).') OR `user_id` IN ('.implode(',', $user_ids).'))');

        $this->line(' - 2/3 Adding comments to index array...');
        foreach ($comments as &$comment)
        {
            // Otherwise content is hidden
            if (isset($content_type_by_id[$comment->content_id])) {
                if (! $comment->body || $comment->body == '') {
                    $comment->body = null;
                }

                if ($comment->body) {
                    $index_fields['cc' . $comment->id] = [
                        'id' => 'null',
                        'user_id' => (int) $comment->user_id,
                        'content_id' => (int) $comment->content_id,
                        'content_type' => DB::getPdo()->quote($content_type_by_id[$comment->content_id]),
                        'comment_id' => (int) $comment->id,
                        'destination_id' => 'null',
                        'title' => 'null',
                        'body' => ($comment->body ? DB::getPdo()->quote($this->safe($comment->body)) : 'null'),
                        'updated_at' => 'NOW()',
                        'created_at' => 'NOW()',
                    ];
                }
            }
        }
        $this->info(' + 3/3 Comments are ready');

        if (! $void_return) {
            return $comments;
        }
    }

    protected function safe($string)
    {
        return full_text_safe($string);
    }

    public function get_object_ids($object)
    {
        $object_ids = [];

        if (count($object)) {
            foreach ($object as &$item)
            {
                $object_ids[] = $item->id;
            }
        }

        return $object_ids;
    }
}
