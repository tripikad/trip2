<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\User;
use App\Destination;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function search(Request $request, $search_type = false)
    {
        if ($search_type) {
            if (! in_array($search_type, array_keys(config('search.types')))) {
                abort(404);
            }
        }

        $q = trim($request->input('q'));
        $active_search = 'forum';
        if ($q && ! empty($q)) {
            foreach (array_keys(config('search.types')) as $type) {
                $counts[$type] = $this->getResultsCountByType($type, $q);
                $tabs[$type]['cnt'] = $counts[$type];
                $tabs[$type]['modifier'] = $counts[$type];
                $tabs[$type]['title'] = trans('search.tab.'.$type);
                $tabs[$type]['route'] = $counts[$type] ? '/search/'.$type.'?q='.$q : '#';
            }

            $active_search = $search_type ? $search_type : 'forum';

            if ($active_search == 'forum' && $counts['forum'] == 0) {
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
            $results = $tabs = null;
        }

        return response()
            ->view('pages.search.show', ['request' => $request, 'results' => $results, 'active_search' => $active_search, 'tabs' => $tabs])
            ->header('Cache-Control', 'public, s-maxage='.config('cache.search.header'));
    }

    public function show()
    {
        $viewVariables = [];

        return response()
            ->view('pages.search.show', $viewVariables)
            ->header('Cache-Control', 'public, s-maxage='.config('cache.search.header'));
    }

    private function modifyForumResults($results, $ajax)
    {
        foreach ($results as $key => $item) {
            if (! $ajax) {
                $results[$key]['short_body_text'] = (strlen($item->body) > 300) ? substr($item->body, 0, 300).'...' : $item->body;
            }

            $results[$key]['comments_count'] = count($item->comments);
            $results[$key]['route'] = route('content.show', [$item->type, $item]);
            $results[$key]['user_img'] = $item->user->imagePreset();
        }
    }

    private function modifyUserResults($results)
    {
    }

    private function modifyBlogResults($results)
    {
    }

    private function modifyFlightResults($results, $ajax)
    {
        foreach ($results as $key => $item) {
            if (! $ajax) {
                $results[$key]['content_img'] = $item->imagePreset('small_square');
                $results[$key]['destinations'] = $item->destinations;
            }

            $results[$key]['route'] = route('content.show', [$item->type, $item]);
        }
    }

    private function modifyNewsResults($results)
    {
        foreach ($results as $key => $item) {
            $results[$key]['short_body_text'] = (strlen($item->body) > 300) ? substr($item->body, 0, 300).'...' : $item->body;
            $results[$key]['route'] = route('content.show', [$item->type, $item]);
            $results[$key]['comments_count'] = count($item->comments);
            $results[$key]['content_img'] = $item->imagePreset('small_square');
        }
    }

    private function modifyDestinationResults($results, $ajax)
    {
        $destinations = Destination::getNames();
        foreach ($results as $key => $item) {
            $results[$key]['path'] = $destinations[$item->id];
            $parent = $item->parent()->first();
            $results[$key]['parent'] = $parent;

            if ($ajax) {
                $results[$key]['name'] = $parent ? $item->name.' > '.$parent->name : $item->name;
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
        $builder = $this->getSearchBuilderByType($type, $q);

        return $builder->count();
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
        $builder = $this->getSearchBuilderByType($type, $q);
        $res = $builder->simplePaginate(config('search.types.'.$type.'.items_per_page'));
        $res->setPath(env('FULL_BASE_URL').'search/'.$type);
        $res->appends(['q' => $q]);

        return $res;
    }

    protected function getSearchBuilderByType($type, $q)
    {
        $order_type = config('search.types.'.$type.'.order_type') ? config('search.types.'.$type.'.order_type') : 'ASC';
        $order_by = config('search.types.'.$type.'.order')?config('search.types.'.$type.'.order'):null;

        switch ($type) {
            case 'destination':
                $res = Destination::where('name', 'LIKE', '%'.$q.'%');
                break;
            case 'user':
                $res = User::whereVerified(1)->where('name', 'LIKE', '%'.$q.'%');
                break;
            case 'blog':
                $res = Content::where(['type' => 'blog', 'status' => 1])->where('title', 'LIKE', '%'.$q.'%');
                break;
            case 'news':
                $res = Content::where(['type' => 'news', 'status' => 1])->where('title', 'LIKE', '%'.$q.'%');
                break;
            case 'flight':
                $res = Content::where(['type' => 'flight', 'status' => 1])->where('title', 'LIKE', '%'.$q.'%');
                break;
            case 'forum':
                $res = Content::whereIn('type', ['forum', 'buysell', 'expat'])->whereStatus(1)->where('title', 'LIKE', '%'.$q.'%');
                break;
            default:
                   throw new Exception('Invalid search type');
        }

        if($order_by)
            $res->orderBy($order_by, $order_type);

        return $res;
    }

    public function ajaxsearch(Request $request)
    {
        $q = trim($request->input('q'));
        $header_search = $request->input('header_search');
        $total_cnt = 0;

        if ($q && ! empty($q)) {
            $types = ['destination', 'flight', 'forum'];
            $total_cnt = $this->getTotalCount($q, $types);
            $remaining_cnt = config('search.ajax_results');
            foreach ($types as $type) {
                if ($remaining_cnt > 0) {
                    $builder = $this->getSearchBuilderByType($type, $q);

                    //active flight offers
                    if ($type == 'flight') {
                        $builder->where('end_at', '>=', Carbon::now());
                    }

                    $results[$type] = $builder->take($remaining_cnt)->get();
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
            return;
        }

        if ($total_cnt == 0) {
            return;
        }

        $footer_modifier = $header_search?'m-icon m-small':'m-icon';

        return response()
            ->view('component.searchblock', [
                'results' => $results, 
                'total_cnt' => $total_cnt, 
                'q' => $q, 
                'header_search' => $header_search,
                'footer_modifier' => $footer_modifier
            ]);
    }
}
