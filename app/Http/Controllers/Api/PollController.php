<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Poll;
use App\PollResult;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth as Auth;

class PollController extends Controller
{
    /**
     * @param Poll $poll
     * @return bool
     */
    protected function userHasAnswered(Poll $poll, Request $request)
    {
        if ($poll->anonymous) {
            $ip = $request->ip();
            $poll_results = $poll
                ->results()
                ->where('ip_address', $ip)
                ->first();
            return $poll_results ? true : false;
        } else {
            $user_id = Auth::user()->id;
            $poll_results = $poll
                ->results()
                ->where('user_id', $user_id)
                ->first();
            return $poll_results ? true : false;
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getFrontPagePoll(Request $request)
    {
        $today = Carbon::today();
        $poll = Poll::where('front_page', true)
            ->where('active', true)
            ->where('start_date', '<=', $today->format('Y-m-d'))
            ->where(function ($q) use ($today) {
                $q->where('end_date', '>=', $today->format('Y-m-d'))->orWhere('end_date', null);
            })
            ->with('poll_options')
            ->first();

        if ($poll) {
            if (!$poll->anonymous && !Auth::check()) {
                return response()->json(null, 404);
            }

            if ($this->userHasAnswered($poll, $request)) {
                return response()->json([
                    'poll' => $poll,
                    'results' => $poll->getFormattedResults()
                ]);
            } else {
                return response()->json([
                    'poll' => $poll
                ]);
            }
        } else {
            return response()->json(null, 404);
        }
    }

    /**
     * @param Poll $poll
     * @param Request $request
     * @return JsonResponse
     */
    public function getPoll(Poll $poll, Request $request)
    {
        if (!$poll->anonymous && !Auth::check()) {
            return response()->json(null, 404);
        }

        $today = Carbon::today();
        if (
            $poll->active &&
            $poll->start_date <= $today->format('Y-m-d') &&
            ($poll->end_date >= $today->format('Y-m-d') || $poll->end_date === null)
        ) {
            if ($this->userHasAnswered($poll, $request)) {
                return response()->json([
                    'poll' => $poll,
                    'results' => $poll->getFormattedResults()
                ]);
            } else {
                $poll->loadMissing('poll_options');
                return response()->json([
                    'poll' => $poll
                ]);
            }
        } else {
            return response()->json(null, 404);
        }
    }

    /**
     * @param Poll $poll
     * @param Request $request
     * @return JsonResponse
     */
    public function answer(Poll $poll, Request $request)
    {
        //check if answered
        if ($this->userHasAnswered($poll, $request)) {
            return response()->json(null, 403);
        }

        if (!$poll->anonymous && !Auth::check()) {
            return response()->json(null, 403);
        }

        $value = (int) $request->post('value');

        if (!$value) {
            return response()->json(null, 404);
        }

        $poll_option = $poll
            ->poll_options()
            ->where('id', $value)
            ->first();
        if (!$poll_option) {
            return response()->json(null, 403);
        }

        $result = new PollResult();
        $result->poll_option_id = $poll_option->id;
        $result->poll_id = $poll->id;

        if ($poll->anonymous) {
            $result->ip_address = $request->ip();
        } else {
            $result->user_id = Auth::user()->id;
        }

        $result->save();

        $poll->answered++;
        $poll->save();
        $poll->refresh();

        return response()->json([
            'poll' => $poll,
            'results' => $poll->getFormattedResults()
        ]);
    }
}
