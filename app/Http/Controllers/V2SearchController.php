<?php

namespace App\Http\Controllers;

use App\User;
use App\Image;
use App\Content;
use Carbon\Carbon;
use App\Searchable;
use App\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $sort_order = $request->get('sort_order', 'updated_at');
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

        foreach ($search_type_keys as $key => $type) {
            $key_value = array_search($type, $search_type_keys);

            if ($q && ! empty($q)) {
                if ($active_search == $type) {
                    // Perform results & count query

                    $data = $this->searchByKeyword($this->search_types[$type], $q, $this->search_limit, $sort_order);

                    if ($data['count'] > 0) {
                        $this->default_found = true;
                    }
                } else {
                    // Perform count query only

                    $data['count'] = $this->searchByKeyword($this->search_types[$type], $q, $sort_order, null, true) ?? 0;
                }

                if ($this->default_active_search == 'forum' && $data['count'] == 0 && ! $this->default_found) {
                    $next_key = $key_value + 1;

                    if (isset($search_type_keys[$next_key])) {
                        $active_search = $search_type_keys[$next_key];
                    }
                }
            }

            $original_key = $search_type_keys[$key_value];

            $tabs[$original_key]['count'] = $data['count'];
            $tabs[$original_key]['title'] = trans('search.tab.'.$original_key);
            $tabs[$original_key]['route'] = $data['count'] ? route('search.results.type', [$original_key, 'q='.$q]) : '#';
        }

        $tabs_component = collect();
        foreach ($tabs as $type => &$tab) {
            $tabs_component->push(
                component('HeaderTab')->with('title', $tab['title'])
                    ->with('route', $tab['route'])
                    ->with('count', $tab['count'])
                    ->with('active', ($type == $active_search ? true : false))
            );
        }

        Log::info('User searched', [
            'search' => $q,
            'sort_order' => $sort_order,
            'user' => auth()->check() ? 'logged' : 'unlogged',
        ]);

        $data['paginate']->withPath(env('FULL_BASE_URL').'search/'.$active_search);
        $data['paginate']->appends(['q' => $q, 'sort_order' => $sort_order]);

        $search_results = collect();

        foreach ($data['items'] as $item) {
            if ($active_search == 'flight') {
                $search_results->push(
                    component('SearchRow')->with('title', str_limit($item->title, 80))
                        ->with('route', route($item->type.'.show', [$item->slug]))
                        ->with('date', Carbon::createFromFormat('Y-m-d H:i:s', $item->updated_at)->format('d.m.Y H:i'))
                        ->with('image_alt', $item->imagePreset('small_square'))
                        ->with('body', str_limit(strip_tags($item->body ?? '&nbsp;'), 300))
                        ->with('badge', ($item->price ? $item->price.'€' : null))
                );
            } elseif ($active_search == 'news') {
                $search_results->push(
                    component('SearchRow')->with('title', str_limit($item->title, 80))
                        ->with('route', route($item->type.'.show', [$item->slug]))
                        ->with('date', Carbon::createFromFormat('Y-m-d H:i:s', $item->updated_at)->format('d.m.Y H:i'))
                        ->with('image_alt', $item->imagePreset('small_square'))
                        ->with('body', str_limit(strip_tags($item->body ?? '&nbsp;'), 300))
                        ->with('badge', $item->comments->count())
                );
            } elseif ($active_search == 'destination') {
                $parent = $item->parent()->first();
                $search_results->push(
                    component('SearchRow')->with('title', ($parent ? $parent->name.' › ' : '').$item->name)
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
                        ->with('date', Carbon::createFromFormat('Y-m-d H:i:s', $item->updated_at)->format('d.m.Y H:i'))
                        ->with('image', $item->user->imagePreset('small_square'))
                        ->with('image_title', $item->user->name)
                        ->with('body', str_limit(strip_tags($item->body ?? '&nbsp;'), 300))
                        ->with('badge', $item->comments->count())
                );
            }
        }

        $tag = component('Tag')
            ->is('white');

        if ($sort_order == 'updated_at') {
            $tag->with('route', route('search.results.type', [$active_search, 'q='.$q.'&sort_order=relevance']))
                ->with('title', trans('search.results.relevance_first'));
        } else {
            $tag->with('route', route('search.results.type', [$active_search, 'q='.$q.'&sort_order=updated_at']))
                ->with('title', trans('search.results.newest_first'));
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
                        ->with('route', route('search.results.type', [$active_search, 'sort_order='.$sort_order]))
                        ->with('fields',
                            collect()->push(
                                component('FormSearchField')->with('name', 'q')
                                    ->with('placeholder', trans('frontpage.index.search.title'))
                                    ->with('value', $q)
                            )
                        )
                )
                ->push(
                    component('Meta')
                        ->is('center')
                        ->with('items', collect()->push($tag))
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

    protected function findSearchableIds($find, $types, $limit, $keyword_detailed, $keyword, $sort_order = 'relevance', $count_only = false)
    {
        $sort_order_types = [
            'relevance',
            'created_at',
            'updated_at',
            'id',
        ];

        if (! in_array($sort_order, $sort_order_types, true)) {
            $sort_order = 'relevance';
        }

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
            ($sort_order == 'relevance' ?
                DB::raw('MATCH (`title`, `body`) AGAINST ('.DB::getPdo()->quote($keyword_detailed).' IN BOOLEAN MODE) AS `relevance`') :
                DB::raw('0 AS `relevance`')
            ),
            ($rank_higher_where_not ?
                DB::raw('IF(`'.$rank_higher_where_not.'` IS NULL, 100, 0) AS `sum_up_relevance`') :
                DB::raw('0 AS `sum_up_relevance`')
            ),
        ])->distinct()
            ->where(function ($query) use ($keyword_detailed, $keyword) {
                $query->whereRaw('MATCH (`title`, `body`) AGAINST ('.DB::getPdo()->quote($keyword_detailed).' IN BOOLEAN MODE)');

                if ($keyword && $keyword != '') {
                    $query->orWhereRaw('MATCH (`title`, `body`) AGAINST ('.DB::getPdo()->quote($keyword).' IN BOOLEAN MODE)');
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

                $data['items'] = $data['items']->with($with);

                if ($sort_order == 'relevance') {
                    $data['items'] = $data['items']->orderBy(DB::raw('FIELD(`id`, '.implode(',', $data['item_ids']).')', 'ASC'));
                } else {
                    $data['items'] = $data['items']->orderBy($sort_order, 'DESC');
                }

                $data['items'] = $data['items']->get();
            } elseif ($find == 'destination' && count($data['item_ids'])) {
                $data['items'] = Destination::whereIn('id', $data['item_ids']);

                if ($sort_order == 'relevance') {
                    $data['items'] = $data['items']->orderBy(DB::raw('FIELD(`id`, '.implode(',', $data['item_ids']).')', 'ASC'));
                } else {
                    $data['items'] = $data['items']->orderBy('id', 'DESC');
                }

                $data['items'] = $data['items']->get();
            } elseif ($find == 'user' && count($data['item_ids'])) {
                $data['items'] = User::whereIn('id', $data['item_ids'])
                    ->with('images');

                if ($sort_order == 'relevance') {
                    $data['items'] = $data['items']->orderBy(DB::raw('FIELD(`id`, '.implode(',', $data['item_ids']).')', 'ASC'));
                } else {
                    $data['items'] = $data['items']->orderBy($sort_order, 'DESC');
                }

                $data['items'] = $data['items']->get();
            }
        }

        return $data;
    }

    protected function searchByKeyword($type, $keyword, $limit = 30, $sort_order = 'relevance', $count_only = false)
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

                $keyword_detailed[] = ''.$detailed_prefix.$keys.($count == count($keyword_array) ? '' : '').'';
                $keyword[] = '('.$prefix.$keys.($count == count($keyword_array) ? '*' : '').')';
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
            $data = $this->findSearchableIds('destination', null, $limit, $keyword_detailed, $keyword, $sort_order, $count_only);
        } elseif (is_string($type) && $type == 'user') {
            $data = $this->findSearchableIds('user', null, $limit, $keyword_detailed, $keyword, $sort_order, $count_only);
        } else {
            $data = $this->findSearchableIds('content', $type, $limit, $keyword_detailed, $keyword, $sort_order, $count_only);
        }

        if ($count_only) {
            $data = $data['count'];
        }

        return $data;
    }

    public function ajaxsearch(Request $request)
    {
        $keyword = trim($request->get('q'));
        $sort_order = trim($request->get('sort_order', 'relevance'));

        $destinations = $this->searchByKeyword('destination', $keyword, 5, $sort_order);
        $flight = $this->searchByKeyword('flight', $keyword, 5, $sort_order);
        $forum = $this->searchByKeyword(['forum', 'buysell', 'expat'], $keyword, 3, $sort_order);

        $contents = [];
        foreach (['destinations', 'flight', 'forum'] as &$type) {
            if (isset(${$type}['items']) && ${$type}['items'] && count(${$type}['items'])) {
                foreach (${$type}['items'] as &$item) {
                    $response = [];
                    if ($type == 'forum') {
                        $response['category'] = 'forum';
                    } elseif ($type == 'flight') {
                        $response['category'] = 'flight';
                    } elseif ($type == 'destinations') {
                        $response['category'] = 'destination';
                    }

                    if (! isset($item['title']) && isset($item['name'])) {
                        $parent = $item->parent()->first();
                        $response['title'] = ($parent ? $parent->name.' › ' : '').$item['name'];
                    } else {
                        $response['title'] = str_limit($item['title'], 65);
                    }

                    $response['badge'] = '';
                    if (isset($item['type'])) {
                        $response['route'] = route($item['type'].'.show', $item['slug']);

                        if ($item['type'] != 'flight') {
                            //$response['badge'] = $item->comments->count();
                            //$response['badge_color'] = 'red';
                        } else {
                            $response['badge'] = ($item['price'] ? $item['price'].'€' : null);
                            $response['badge_color'] = 'red';
                        }
                    } elseif ($type == 'destinations') {
                        $response['route'] = route('destination.showSlug', $item['slug']);
                    } elseif ($type == 'user') {
                        $response['route'] = route('user.show', $item['id']);
                    }

                    if (! isset($contents[$response['category']])) {
                        $contents[$response['category']] = [
                            'title' => '',
                            'items' => [],
                        ];
                    }

                    $contents[$response['category']]['title'] = trans('search.tab.'.$response['category']);
                    if ($response['category'] == 'destination') {
                        $contents[$response['category']]['icon'] = 'icon-pin';
                    } elseif ($response['category'] == 'flight') {
                        $contents[$response['category']]['icon'] = 'icon-tickets';
                    } else {
                        $contents[$response['category']]['icon'] = 'icon-comment';
                    }

                    $contents[$response['category']]['items'][] = $response;
                }
            }
        }

        $results_count = round($forum['count'] + $flight['count'] + $destinations['count']);

        return array_merge($contents,
                ['attributes' => [
                    'message' => $results_count ? trans('search.results.all') : trans('search.results.noresults'),
                    'total' => $results_count,
                    'route' => route('search.results', ['q='.urlencode($keyword)]),
                ],
            ]);
    }
}
