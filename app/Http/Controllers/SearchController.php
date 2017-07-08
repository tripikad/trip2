<?php

namespace App\Http\Controllers;

use App\User;
use App\Content;
use App\Searchable;
use Carbon\Carbon;
use App\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class SearchController extends Controller
{
    private $content = null;
    private $content_results = [];
    private $content_counts = [];
    private $content_types = ['news', 'flight', 'forum', 'buysell', 'expat'];

    public function search(Request $request, $search_type = false)
    {
        $this->content_types = config('search.content_types');

        if ($search_type) {
            if (! in_array($search_type, array_keys(config('search.types')))) {
                abort(404);
            }
        }

        $q = trim($request->input('q'));
        $active_search = 'forum';
        $tabs = [];

        if ($q && ! empty($q)) {
            $active_search = $search_type ? $search_type : 'forum';

            if ($active_search == 'forum' && isset($counts) && $counts['forum'] == 0) {
                foreach ($counts as $type => $cnt) {
                    if ($cnt && $cnt > 0) {
                        $active_search = $type;
                        break;
                    }
                }
            }

            foreach (array_keys(config('search.types')) as $type) {
                $counts[$type] = ($q && ! empty($q) ? $this->getResultsCountByType($type, $q) : 0);
                $tabs[$type]['cnt'] = $counts[$type];
                $tabs[$type]['modifier'] = $counts[$type];
                $tabs[$type]['title'] = trans('search.tab.'.$type);
                $tabs[$type]['route'] = $counts[$type] ? '/search/'.$type.'?q='.$q : '#';
            }

            $tabs[$active_search]['modifier'] = 'm-active';
            $results = $this->getSearchResultsByType($active_search, $q);
            $results = $this->modifyResultsByType($active_search, $results);
        } else {
            $results = null;
        }

        Log::info('User searched', [
            'search' => $q,
            'user' => auth()->check() ? 'logged' : 'unlogged',
        ]);

        return response()
            ->view('pages.search.show', ['request' => $request, 'results' => $results['items'], 'paginate' => $results['paginate'], 'active_search' => $active_search, 'tabs' => $tabs])
            ->header('Cache-Control', 'public, s-maxage='.config('cache.search.header'));
    }

    private function modifyForumResults($results, $ajax)
    {
    }

    private function modifyUserResults($results)
    {
    }

    private function modifyBlogResults($results)
    {
    }

    private function modifyFlightResults($results, $ajax)
    {
    }

    private function modifyNewsResults($results)
    {
    }

    private function modifyDestinationResults($results, $ajax)
    {
        $destinations = Destination::getNames();
        foreach ($results['items'] as $key => &$item) {
            $results['items'][$key]['path'] = $destinations[$item->id];
            $parent = $item->parent()->first();
            $results['items'][$key]['parent'] = $parent;

            if ($ajax) {
                $results['items'][$key]['name'] = $parent ? $item->name.' › '.$parent->name : $item->name;
            }
        }
    }

    protected function modifyResultsByType($type, &$results, $ajax = false)
    {
        switch ($type) {
            case 'forum': $this->modifyForumResults($results, $ajax); break;
            case 'destination': $this->modifyDestinationResults($results, $ajax); break;
            case 'user': $this->modifyUserResults($results); break;
            case 'blog': $this->modifyBlogResults($results); break;
            case 'news': $this->modifyNewsResults($results); break;
            case 'flight': $this->modifyFlightResults($results, $ajax); break;
            default:
                throw new Exception('Can not modify search type results');
        }

        return $results;
    }

    protected function getResultsCountByType($type, $q)
    {
        $this->getSearchResultsByType($type, $q);

        return $this->content_counts[$type];
    }

    protected function getTotalCount($q, $types = [])
    {
        $res = 0;
        $types = $types ? $types : array_keys(config('search.types'));
        foreach ($types as $type) {
            $res += intval($this->getResultsCountByType($type, $q));
        }

        return $res;
    }

    protected function getSearchResultsByType($type, $q)
    {
        $perPage = config('search.types.'.$type.'.items_per_page');

        $post_type = $type;
        if ($type == 'forum') {
            $post_type = ['forum', 'buysell', 'expat'];
        }

        $this->content_results[$type] = $this->searchByKeyword($post_type, $q, $perPage);

        if (isset($this->content_results[$type])) {
            $this->content_counts[$type] = $this->content_results[$type]['count'];

            $res = $this->content_results[$type]['paginate'];

            $res->withPath(env('FULL_BASE_URL').'search/'.$type);
            $res->appends(['q' => $q]);

            return [
                'paginate' => $res,
                'items' => $this->content_results[$type]['items'],
            ];
        } else {
            $this->content_counts[$type] = 0;

            return;
        }
    }

    public function countByKeyword($type, $keyword)
    {
        return $this->searchByKeyword($type, $keyword, 0, true);
    }

    public function findSearchableIds($find = 'content', $types = ['forum', 'buysell', 'expat'], $limit = 30, $keyword_detailed, $keyword, $count_only = false)
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

        $data['paginate'] = $data['paginate']->orderBy(DB::raw('`relevance` + `sum_up_relevance`'), 'desc')
            ->paginate($limit);

        $data['count'] = $data['paginate']->total();

        if ($data['count'] && ! $count_only) {
            foreach ($data['paginate'] as &$item) {
                if ($item->$item_id_key && ! in_array($item->$item_id_key, $data['item_ids'], true)) {
                    $data['item_ids'][] = $item->$item_id_key;
                }
            }

            if ($find == 'content' && count($data['item_ids'])) {
                $data['items'] = Content::whereIn('id', $data['item_ids'])
                    ->with('comments')
                    ->orderBy(DB::raw('FIELD(`id`, ' . implode(',', $data['item_ids']) . ')', 'ASC'))
                    ->get();
            } elseif ($find == 'destination' && count($data['item_ids'])) {
                $data['items'] = Destination::whereIn('id', $data['item_ids'])
                    ->orderBy(DB::raw('FIELD(`id`, ' . implode(',', $data['item_ids']) . ')', 'ASC'))
                    ->get();
            } elseif ($find == 'user' && count($data['item_ids'])) {
                $data['items'] = User::whereIn('id', $data['item_ids'])
                    ->orderBy(DB::raw('FIELD(`id`, ' . implode(',', $data['item_ids']) . ')', 'ASC'))
                    ->get();
            }

        }

        if ($count_only) {
            return $data['count'];
        } else {
            return $data;
        }
    }

    public function searchByKeyword($type, $keyword, $limit = 30, $count_only = false)
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
                    $detailed_prefix = '';
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
            $data = $this->findSearchableIds('content', $type, $limit, $keyword_detailed, $keyword);
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
