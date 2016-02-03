<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\User;
use App\Destination;

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
        if ($q && ! empty($q) && strlen($q) >= config('search.length')) {
            foreach (array_keys(config('search.types')) as $type) {
                $res[$type] = $this->getResultsCountByType($type, $q);
            }

            $active_search = $search_type ? $search_type : 'destination';

            if ($active_search == 'destination' && $res['destination'] == 0) {
                foreach ($res as $type => $cnt) {
                    if ($cnt && $cnt > 0) {
                        $active_search = $type;
                        break;
                    }
                }
            }

            $tags = $this->getTags($res, $active_search, $q);
            $results = $this->getSearchResultsByType($active_search, $q);
        } else {
            $results = $active_search = $tags = null;
        }

        return response()
            ->view('pages.search.results', ['request' => $request, 'results' => $results, 'active_search' => $active_search, 'tags' => $tags]);
    }

    protected function getTags($res, $active_search, $q)
    {
        $tags = [];
        foreach ($res as $type => $cnt) {
            $modifier = $active_search == $type ? 'm-green m-active' : 'm-green';
            $route = $cnt ? '/search/'.$type.'?q='.$q : '#';
            $title = trans('search.tag.'.$type).' ('.$cnt.')';
            $tags[] = ['modifiers' => $modifier, 'route' => $route, 'title' => $title];
        }

        return $tags;
    }

    protected function getResultsCountByType($type, $q)
    {
        $builder = $this->getSearchBuilderByType($type, $q);

        return $builder->count();
    }

    protected function getTotalCount($q)
    {
        $res = 0;
        foreach (array_keys(config('search.types')) as $type) {
            $res += intval($this->getResultsCountByType($type, $q));
        }

        return $res;
    }

    protected function getSearchResultsByType($type, $q)
    {
        $builder = $this->getSearchBuilderByType($type, $q);

        $order_type = config('search.types.'.$type.'.order_type') ? config('search.types.'.$type.'.order_type') : 'ASC';
        $res = $builder->orderBy(config('search.types.'.$type.'.order'), $order_type)->simplePaginate(config('search.types.'.$type.'.items_per_page'));
        $res->setPath(env('FULL_BASE_URL').'search/'.$type);
        $res->appends(['q' => $q]);

        return $res;
    }

    protected function getSearchBuilderByType($type, $q)
    {
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

        return $res;
    }

    public function ajaxsearch(Request $request)
    {
        $q = trim($request->input('q'));

        if ($q && ! empty($q) && strlen($q) >= config('search.length')) {
            $total_cnt = $this->getTotalCount($q);
            $remaining_cnt = config('search.ajaxResults');
            foreach (array_keys(config('search.types')) as $type) {
                $results[$type] = $this->getSearchBuilderByType($type, $q)->take($remaining_cnt)->get();
                if (count($results[$type])) {
                    if (count($results[$type]) == config('search.ajaxResults')) {
                        break;
                    } else {
                        $remaining_cnt -= count($results[$type]);
                    }
                } else {
                    unset($results[$type]);
                }
            }
        } else {
            $results = null;
        }

        return response()
            ->view('component.searchblock', ['results' => $results, 'total_cnt' => $total_cnt]);
    }
}
