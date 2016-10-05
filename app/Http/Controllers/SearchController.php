<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Content;
use App\User;
use App\Destination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

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

        foreach (array_keys(config('search.types')) as $type) {
            $counts[$type] = ($q && ! empty($q) ? $this->getResultsCountByType($type, $q) : 0);
            $tabs[$type]['cnt'] = $counts[$type];
            $tabs[$type]['modifier'] = $counts[$type];
            $tabs[$type]['title'] = trans('search.tab.'.$type);
            $tabs[$type]['route'] = $counts[$type] ? '/search/'.$type.'?q='.$q : '#';
        }

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
            ->view('pages.search.show', ['request' => $request, 'results' => $results, 'active_search' => $active_search, 'tabs' => $tabs])
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
        foreach ($results as $key => $item) {
            $results[$key]['path'] = $destinations[$item->id];
            $parent = $item->parent()->first();
            $results[$key]['parent'] = $parent;

            if ($ajax) {
                $results[$key]['name'] = $parent ? $item->name.' › '.$parent->name : $item->name;
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
        $types = $this->content_types;

        if (in_array($type, $types)) {
            if (! $this->content) {
                $this->content = $this->getSearchBuilderByType('content', $q);

                foreach ($this->content as $content) {
                    if ($content->type == 'expat' || $content->type == 'buysell') {
                        $content->type = 'forum';
                    }

                    $this->content_results[$content->type][] = $content;
                }

                foreach ($types as $t) {
                    if (isset($this->content_results[$t])) {
                        $this->content_results[$t] = collect($this->content_results[$t]);
                    }
                }
            }
        } else {
            $builder = $this->getSearchBuilderByType($type, $q);
            $this->content_results[$type] = $builder;
        }

        if (isset($this->content_results[$type])) {
            $this->content_counts[$type] = $this->content_results[$type]->count();

            $res = $this->content_results[$type];
            $perPage = config('search.types.'.$type.'.items_per_page');
            $currentPage = (int) Input::get('page', 1);

            $res = new LengthAwarePaginator(
                $res->forPage($currentPage, $perPage), $res->count(), $perPage, $currentPage
            );

            $res->setPath(env('FULL_BASE_URL').'search/'.$type);
            $res->appends(['q' => $q]);

            return $res;
        } else {
            $this->content_counts[$type] = 0;

            return;
        }

    }

    protected function getSearchBuilderByType($type, $q)
    {
        mb_internal_encoding('UTF-8');
        $order_type = config('search.types.'.$type.'.order_type') ? config('search.types.'.$type.'.order_type') : 'ASC';
        $order_by = config('search.types.'.$type.'.order') ? config('search.types.'.$type.'.order') : 'created_at';

        $types = $this->content_types;

        if ($type == 'destination') {
            $res = Cache::remember('search-destination-'.urlencode($q), 15, function() use ($q, $order_by, $order_type) {
                return Destination::whereRaw('LOWER(`name`) LIKE ?', ['%'.mb_strtolower($q).'%'])
                    ->orderBy($order_by, $order_type)
                    ->get();
            });
        } elseif ($type == 'user') {
            $res = Cache::remember('search-user-'.urlencode($q), 15, function() use ($q, $order_by, $order_type) {
                return User::whereVerified(1)
                    ->whereRaw('LOWER(`name`) LIKE ?', ['%'.mb_strtolower($q).'%'])
                    ->orderBy($order_by, $order_type)
                    ->get();
            });
        } elseif ($type == 'content' || in_array($type, $types)) {
            $res = Cache::remember('search-content-'.urlencode($q), 15, function() use ($q, $order_by, $order_type, $types) {
                return Content::leftJoin('comments', function ($query) use ($q) {
                    $query->on('comments.content_id', '=', 'contents.id')
                        ->on('comments.id', '=',
                            DB::raw('(SELECT `id` FROM comments WHERE `content_id` = `contents`.`id` AND LOWER(`body`) LIKE '.DB::getPdo()->quote(mb_strtolower('%'.$q.'%')).' AND `status` = 1 LIMIT 1)'));
                })
                    ->select('contents.*')
                    ->whereIn('contents.type', $types)
                    ->where('contents.status', 1)
                    ->whereRaw('IF(`contents`.`type` = \'flight\', `contents`.`end_at` >= UNIX_TIMESTAMP(?), 1=1) AND (LOWER(`contents`.`title`) LIKE ? OR LOWER(`contents`.`body`) LIKE ? OR `comments`.`body` != \'\')', [Carbon::now(), '%'.mb_strtolower($q).'%', '%'.mb_strtolower($q).'%'])
                    ->orderBy('contents.'.$order_by, $order_type)
                    ->get();
            });

            $order_by = null;
        } else {
            throw new \Exception('Invalid search type');
        }

        return $res;
    }

    public function ajaxsearch(Request $request)
    {
        $q = trim($request->input('q'));

        if ($request->has('types')) {
            $types = explode(',', $request->types);
        } else {
            $types = ['destination', 'flight', 'forum'];
        }

        $header_search = $request->input('header_search');

        if ($q && ! empty($q)) {
            $total_cnt = $this->getTotalCount($q);
            $remaining_cnt = config('search.ajax_results');
            foreach ($types as $type) {
                if ($remaining_cnt > 0) {
                    $builder = $this->getSearchResultsByType($type, $q);

                    $results[$type] = $builder->take($remaining_cnt);
                    if (count($results[$type])) {
                        $this->modifyResultsByType($type, $results[$type], true);
                        if (count($results[$type]) == config('search.ajax_results')) {
                            break;
                        } else {
                            $remaining_cnt -= count($results[$type]);
                        }
                    } else {
                        unset($results[$type]);
                    }
                }
            }
        } else {
            return '';
        }

        if ($total_cnt == 0) {
            return response()
                ->view('component.searchblock', [
                    'not_found' => trans('search.results.noresults'),
                ]);
        }

        $footer_modifier = $header_search ? 'm-icon m-small' : 'm-icon';

        return response()
            ->view('component.searchblock', [
                'results' => $results,
                'total_cnt' => $total_cnt,
                'q' => $q,
                'header_search' => $header_search,
                'footer_modifier' => $footer_modifier,
            ]);
    }
}
