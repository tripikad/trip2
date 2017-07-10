<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;
use App\Searchable;
use App\Destination;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class V2SearchController extends Controller
{
    private $search_types = [
        'forum' => ['forum', 'buysell', 'expat'],
        'flight' => 'flight',
        'news' => 'news',
        'destination' => 'destination',
        'user' => 'user',
    ];
    private $search_limit = 15;
    private $default_active_search = 'forum';
    private $default_found = false;

    public function search(Request $request, $search_type = false)
    {
        if ($search_type) {
            if (! in_array($search_type, array_keys(config('search.types')))) {
                abort(404);
            }
        }

        $q = trim($request->input('q'));
        $tabs = [];
        $data = [
            'items' => null,
            'paginate' => null,
            'count' => 0,
        ];

        if ($search_type) {
            $this->default_active_search = $search_type;
            $active_search = $search_type;
        } else {
            $active_search = $this->default_active_search;
        }


        $search_type_keys = array_keys($this->search_types);

        foreach ($search_type_keys as $key => $type)
        {
            $key_value = array_search($type, $search_type_keys);

            if ($q && ! empty($q)) {
                if ($active_search == $type) {
                    // Perform results & count query

                    $data = $this->searchByKeyword($this->search_types[$type], $q, $this->search_limit);

                    if ($data['count'] > 0) {
                        $this->default_found = true;
                    }
                } else {
                    // Perform count query only

                    $data['count'] = $this->searchByKeyword($this->search_types[$type], $q, null, true) ?? 0;
                }

                if ($this->default_active_search == 'forum' && $data['count'] == 0 && !$this->default_found) {
                    $next_key = $key_value + 1;

                    if (isset($search_type_keys[$next_key])) {
                        $active_search = $search_type_keys[$next_key];
                    }
                }
            }

            $original_key = $search_type_keys[$key_value];

            $tabs[$original_key]['cnt']=
            $tabs[$original_key]['count'] = $data['count'];
            $tabs[$original_key]['title'] = trans('search.tab.' . $original_key);
            $tabs[$original_key]['route'] = $data['count'] ? route('search.results.type', [$original_key, 'q=' . $q]) : '#';
            $tabs[$original_key]['modifier'] = '';

        }

        $tabs[$active_search]['modifier'] = 'm-active';

        $tabs_component = collect();
        foreach ($tabs as $type => &$tab)
        {
            $tabs_component->push(
                component('HeaderTab')->with('title', $tab['title'])
                    ->with('route', $tab['count'] ? route('search.results.type', [$type, 'q=' . $q]) : '#')
                    ->with('count', $tab['count'])
                    ->with('active', ($type == $active_search ? true : false))
            );
        }

        Log::info('User searched', [
            'search' => $q,
            'user' => auth()->check() ? 'logged' : 'unlogged',
        ]);

        $data['paginate']->withPath(env('FULL_BASE_URL').'search/'.$active_search);
        $data['paginate']->appends(['q' => $q]);

        $search_results = collect();

        foreach ($data['items'] as $item)
        {
            if ($active_search == 'flight') {
                $search_results->push(
                    component('SearchRow')->with('title', str_limit($item->title, 80))
                        ->with('route', route($item->type . '.show', [$item->slug]))
                        ->with('date', Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d.m.Y H:i'))
                        ->with('image_alt', $item->imagePreset('small_square'))
                        ->with('body', str_limit(strip_tags($item->body ?? '&nbsp;'), 300))
                        ->with('badge', $item->price . '€')
                );
            } elseif ($active_search == 'news') {
                $search_results->push(
                    component('SearchRow')->with('title', str_limit($item->title, 80))
                        ->with('route', route($item->type.'.show', [$item->slug]))
                        ->with('date', Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d.m.Y H:i'))
                        ->with('image_alt', $item->imagePreset('small_square'))
                        ->with('body', str_limit(strip_tags($item->body ?? '&nbsp;'), 300))
                        ->with('badge', $item->comments->count())
                );
            } elseif ($active_search == 'destination') {
                $search_results->push(
                    component('SearchRow')->with('title', $item->parent()->first()->name . ' › ' . $item->name)
                        ->with('route', route('destination.showSlug', [$item->slug]))
                        ->with('image_alt', Image::getRandom($item->id))
                );
            } elseif ($active_search == 'user') {
                $search_results->push(
                    component('SearchRow')->with('title', str_limit($item->name, 80))
                        ->with('route', ($item->name != 'Tripi külastaja' ? route('user.show', [$item]) : false))
                        ->with('arc', component('UserImage')
                            ->with('rank', $item->rank * 90)
                            ->with('image', $item->imagePreset('small_square'))
                        )
                );
            } else {
                $search_results->push(
                    component('SearchRow')->with('title', str_limit($item->title, 80))
                        ->with('route', route($item->type.'.show', [$item->slug]))
                        ->with('date', Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('d.m.Y H:i'))
                        ->with('image', $item->user->imagePreset('small_square'))
                        ->with('image_title', $item->user->name)
                        ->with('body', str_limit(strip_tags($item->body ?? '&nbsp;'), 300))
                        ->with('badge', $item->comments->count())
                );
            }

        }

        return layout('1col')
            ->with('title', $q)
            ->with('head_title', trans('site.about'))
            ->with('head_description', '')
            ->with('head_image', Image::getSocial())
            ->with('background_color', 'background-gray')
            ->with('container_background_color', 'background-white')
            ->with('column_class', 'col-10')
            ->with('header', region('Header', collect()
                ->push(
                    component('Form')
                        ->with('method', 'get')
                        ->with('route', route('search.results.type', [$active_search]))
                        ->with('fields',
                            collect()->push(
                                component('FormSearchField')->with('name', 'q')
                                    ->with('placeholder', trans('frontpage.index.search.title'))
                                    ->with('value', $q)
                            )
                        )
                )
                ->push(component('HeaderTabs')
                    ->with('tabs', $tabs_component)
                )
            ))
            ->with('content', collect()
                ->push(component('Search')->with('items', $search_results))
                ->push(region('Paginator', $data['paginate']))
                ->push(component('Promo')->with('promo', 'body'))
            )
            ->with('footer', region('Footer'))
            ->render();
    }

    protected function findSearchableIds($find = 'content', $types = ['forum', 'buysell', 'expat'], $limit = 30, $keyword_detailed, $keyword, $count_only = false)
    {
        $data = [
            'items' => null,
            'paginate' => null,
            'item_ids' => [],
            'count' => 0,
        ];

        $rank_higher_where_not = null;
        if ($find == 'content') {
            $item_id_key = 'content_id';
        } else {
            $types = null;

            if ($find === 'destination') {
                $item_id_key = 'destination_id';
                $rank_higher_where_not = 'content_type';
            } elseif ($find === 'comment') {
                $item_id_key = 'comment_id';
            } elseif ($find === 'user') {
                $item_id_key = 'user_id';
                $rank_higher_where_not = 'content_type';
            } else {
                $item_id_key = 'content_id';
            }
        }

        $data['paginate'] = Searchable::select([
            $item_id_key,
            DB::raw('MATCH (`title`, `body`) AGAINST (' . DB::getPdo()->quote($keyword_detailed) . ' IN BOOLEAN MODE) AS `relevance`'),
            ($rank_higher_where_not ? DB::raw('IF(`'.$rank_higher_where_not.'` IS NULL, 100, 0) AS `sum_up_relevance`') :  DB::raw('0 AS `sum_up_relevance`')),
        ])->distinct()
            ->where(function ($query) use ($keyword_detailed, $keyword) {
                $query->whereRaw('MATCH (`title`, `body`) AGAINST (' . DB::getPdo()->quote($keyword_detailed) . ' IN BOOLEAN MODE)');

                if ($keyword && $keyword != '') {
                    $query->orWhereRaw('MATCH (`title`, `body`) AGAINST (' . DB::getPdo()->quote($keyword) . ' IN BOOLEAN MODE)');
                }
            })->whereNotNull($item_id_key);

        if ($types) {
            if (is_array($types)) {
                $data['paginate'] = $data['paginate']->whereIn('content_type', $types);
            } else {
                $data['paginate'] = $data['paginate']->where('content_type', $types);
            }
        }

        if ($count_only) {
            $data['count'] = $data['paginate']->count();
        } else {
            $data['paginate'] = $data['paginate']->orderBy(DB::raw('`relevance` + `sum_up_relevance`'), 'desc')
                ->paginate($limit);

            $data['count'] = $data['paginate']->total();
        }

        if ($data['count'] && ! $count_only) {
            foreach ($data['paginate'] as &$item) {
                if ($item->$item_id_key && ! in_array($item->$item_id_key, $data['item_ids'], true)) {
                    $data['item_ids'][] = $item->$item_id_key;
                }
            }

            if ($find == 'content' && count($data['item_ids'])) {
                $data['items'] = Content::whereIn('id', $data['item_ids']);

                $with = ['user', 'user.images', 'comments'];
                if ((! is_array($types) && $types == 'flight') || (is_array($types) && in_array('flight', $types))) {
                    $with[] = 'images';
                }

                $data['items'] = $data['items']->with($with)
                    ->orderBy(DB::raw('FIELD(`id`, ' . implode(',', $data['item_ids']) . ')', 'ASC'))
                    ->get();
            } elseif ($find == 'destination' && count($data['item_ids'])) {
                $data['items'] = Destination::whereIn('id', $data['item_ids'])
                    ->orderBy(DB::raw('FIELD(`id`, ' . implode(',', $data['item_ids']) . ')', 'ASC'))
                    ->get();
            } elseif ($find == 'user' && count($data['item_ids'])) {
                $data['items'] = User::whereIn('id', $data['item_ids'])
                    ->with('images')
                    ->orderBy(DB::raw('FIELD(`id`, ' . implode(',', $data['item_ids']) . ')', 'ASC'))
                    ->get();
            }

        }

        return $data;
    }

    protected function searchByKeyword($type, $keyword, $limit = 30, $count_only = false)
    {
        $keyword = trim(preg_replace('/\s+/', ' ', full_text_safe(urldecode($keyword))));
        $keyword = preg_replace('/[+\-><\(\)~*:,\"@]+/', ' ', $keyword);

        $keyword_array = explode(' ', $keyword);
        $keyword = [];
        $keyword_detailed = [];

        if (count($keyword_array) == 1) {
            $prefix = '*';
        } else {
            $prefix = '+';
        }
        $count = 0;

        foreach ($keyword_array as &$keys) {
            ++$count;
            if (trim($keys) != '') {
                if ($count > 1) {
                    $prefix = '-';
                    $detailed_prefix = '+';
                } else {
                    $detailed_prefix = $prefix;
                }

                $keys = rtrim($keys, '+- ');
                $keys = trim($keys, '+- ');

                $keyword_detailed[] = '' . $detailed_prefix . $keys .($count == count($keyword_array) ? '*' : '') .'';
                $keyword[] = '('. $prefix . $keys . ($count == count($keyword_array) ? '*' : '') . ')';
            }
        }
        $keyword = trim(mb_strtolower(implode(' ', $keyword)));
        $keyword_detailed = trim(mb_strtolower(implode(' ', $keyword_detailed)));

        /*if ($add_plus) {
            $keyword = '+'.$keyword;
        } else {
            $keyword = '*'.$keyword;
        }*/

        if (request()->get('detailed', null) === null) {
            $keyword = null;
        }

        if (is_string($type) && $type == 'destination') {
            $data = $this->findSearchableIds('destination', null, $limit, $keyword_detailed, $keyword, $count_only);
        } elseif (is_string($type) && $type == 'user') {
            $data = $this->findSearchableIds('user', null, $limit, $keyword_detailed, $keyword, $count_only);
        } else {
            $data = $this->findSearchableIds('content', $type, $limit, $keyword_detailed, $keyword, $count_only);
        }

        if ($count_only) {
            $data = $data['count'];
        }

        return $data;
    }

    public function ajaxsearch(Request $request)
    {
        $keyword = trim($request->get('q'));

        $forum = $this->searchByKeyword(['forum', 'buysell', 'expat'], $keyword, 5);
        $user = $this->searchByKeyword('user', $keyword, 5);
        $destinations = $this->searchByKeyword('destination', $keyword, 5);

        $contents = [];
        foreach (['forum', 'user', 'destinations'] as &$type)
        {
            if (isset(${$type}['items']) && ${$type}['items'] && count(${$type}['items'])) {
                foreach (${$type}['items'] as &$item)
                {
                    if ($type == 'forum') {
                        $item['category'] = 'forum';
                    } elseif ($type == 'user') {
                        $item['category'] = 'user';
                    } elseif ($type == 'destination') {
                        $item['category'] = 'destination';
                    }

                    $item = $item->getAttributes();
                    if (! isset($item['title']) && isset($item['name'])) {
                        $item['title'] = $item['name'];
                        unset($item['name']);
                    }

                    $contents[] = $item;
                }
            }
        }

        return array_merge(
                ['attributes' => [
                    'total' => round($forum['count'] + $user['count'] + $destinations['count']),
                    'route' => route('search.results', ['q=' . urlencode($keyword)]),
                ]
            ], $contents);
    }
}
