<?php

namespace App\Http\Controllers;

use App\Poll;
use App\PollOption;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PollController extends Controller
{
    public function index(Request $request)
    {
        $pollPaginator = Poll::orderBy('id', 'DESC')->simplePaginate(10);
        $items = Poll::orderBy('id', 'DESC')->get();

        return layout('Two')
            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->with('title', trans('poll.title'))
                    ->with('route', route('poll.index'))
                )
            ))
            ->with('content', collect()
                ->push(
                    component('PollList')
                        ->with('items', $items)
                )
                ->push(region('Paginator', $pollPaginator))
            )

            ->with('sidebar', collect()
                ->push(component('Button')
                    ->with('title', trans('poll.add.new'))
                    ->with('route', route('poll.create'))
                )
            )

            ->with('footer', region('FooterLight'))
            ->render();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        return layout('Two')
            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->with('title', trans('poll.title'))
                    ->with('route', route('poll.index'))
                )
            ))
            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('poll.add.title'))
                )
                ->push(component('FormComponent')
                    ->with('route', route('poll.store'))
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->with('title', trans('poll.question'))
                            ->with('name', 'question')
                            ->with('value', old('question'))
                        )
                        ->push(component('Grid2')
                            ->with('gutter', true)
                            ->with('items', collect()
                                ->push(component('FormDatepicker')
                                    ->with('title', trans('poll.start_date'))
                                    ->with('name', 'start_date')
                                    ->with('value', old('start_date'))
                                )
                                ->push(component('FormDatepicker')
                                    ->with('title', trans('poll.end_date'))
                                    ->with('name', 'end_date')
                                    ->with('value', old('end_date'))
                                )
                            )
                        )
                        ->push(component('PollOption')
                            ->with('label', trans('poll.options'))
                            ->with('name', 'poll_fields')
                            ->with('options', old('poll_fields') ? old('poll_fields') : [])
                            ->with('add_option_label', trans('poll.option.add'))
                            ->with('option_placeholder', trans('poll.option.title'))
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('poll.anonymous'))
                            ->with('name', 'anonymous')
                            ->with('value', old('anonymous'))
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('poll.show_on_frontpage'))
                            ->with('name', 'front_page')
                            ->with('value', old('front_page'))
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('poll.active'))
                            ->with('name', 'active')
                            ->with('value', old('active'))
                        )
                        ->push(component('FormButton')
                            ->is('large')
                            ->with('title', trans('general.save'))
                        )
                    )
                )
            )
            ->with('footer', region('FooterLight'))
            ->render();
    }

    /**
     * @param Poll $poll
     * @param Request $request
     * @return Response
     */
    public function edit(Poll $poll, Request $request)
    {
        $answered = $poll->answered;

        return layout('Two')
            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->with('title', trans('poll.title'))
                    ->with('route', route('poll.index'))
                )
            ))
            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('poll.edit.title'))
                )
                ->push(component('FormComponent')
                    ->with('route', route('poll.update', ['poll' => $poll->id]))
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->with('title', trans('poll.question'))
                            ->with('name', 'question')
                            ->with('value', $answered ? $poll->question : old('question', $poll->question))
                            ->with('disabled', $answered ? true : false)
                        )
                        ->push(component('Grid2')
                            ->with('gutter', true)
                            ->with('items', collect()
                                ->push(component('FormDatepicker')
                                    ->with('title', trans('poll.start_date'))
                                    ->with('name', 'start_date')
                                    ->with('value', $answered ? $poll->start_date->format('Y-m-d') : old('start_date', $poll->start_date->format('Y-m-d')))
                                    ->with('disabled', $answered ? true : false)
                                )
                                ->push(component('FormDatepicker')
                                    ->with('title', trans('poll.end_date'))
                                    ->with('name', 'end_date')
                                    ->with('value', old('end_date', $poll->end_date ? $poll->end_date->format('Y-m-d') : null))
                                )
                            )
                        )
                        ->push(component('PollOption')
                            ->with('label', trans('poll.options'))
                            ->with('name', 'poll_fields')
                            ->with('options', $answered ? $poll->poll_options->pluck('name')->toArray() : old('poll_fields') ?? $poll->poll_options->pluck('name')->toArray())
                            ->with('add_option_label', trans('poll.option.add'))
                            ->with('option_placeholder', trans('poll.option.title'))
                            ->with('disabled', $answered ? true : false)
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('poll.anonymous'))
                            ->with('name', 'anonymous')
                            ->with('value', $answered ? $poll->anonymous : old('anonymous', $poll->anonymous))
                            ->with('disabled', $answered ? true : false)
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('poll.show_on_frontpage'))
                            ->with('name', 'front_page')
                            ->with('value', old('front_page', $poll->front_page))
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('poll.active'))
                            ->with('name', 'active')
                            ->with('value', old('active', $poll->active))
                        )
                        ->push(component('FormButton')
                            ->is('large')
                            ->with('title', trans('general.save'))
                        )
                    )
                )
            )
            ->with('footer', region('FooterLight'))
            ->render();
    }

    protected function validateSaveRequest(Poll $poll = null)
    {
        $request = request();
        $postValues = $request->post();

        if ($poll && $poll->answered) {
            $postValues['start_date'] = $poll->start_date;
            $rules = [
                'end_date' => 'sometimes|date_format:d.m.Y|after_or_equal:start_date'
            ];
        } else {
            $postValues['poll_fields'] = array_filter($postValues['poll_fields']);
            $rules = [
                'question' => 'required',
                'start_date' => 'required|date|date_format:d.m.Y',
                'end_date' => 'sometimes|date|date_format:d.m.Y|after_or_equal:start_date',
                'poll_fields' => 'required|array|min:2'
            ];
        }

        $attribute_names = [
            'question' => trans('poll.question'),
            'start_date' => trans('poll.start_date'),
            'end_date' => trans('poll.end_date'),
        ];

        $messages = [
            'poll_fields.required' => trans('poll.validation.options_required'),
            'poll_fields.min' => trans('poll.validation.options_required'),
            'end_date.after_or_equal' => trans('poll.validation.end_date_invalid'),
        ];

        $validator = Validator::make($postValues, $rules, $messages);
        $validator->setAttributeNames($attribute_names);
        $validator->validate();
    }

    /**
     * @param Poll $poll
     */
    protected function updateFrontPagePoll(Poll $poll)
    {
        if ($poll->front_page) {
            Poll::where('id', '!=', $poll->id)->update(['front_page' => false]);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validateSaveRequest();
        $postValues = $request->post();

        $poll = new Poll();
        $poll->question = $postValues['question'];
        $poll->start_date = Carbon::createFromFormat('d.m.Y', $postValues['start_date']);
        $poll->end_date = $postValues['end_date'] ? Carbon::createFromFormat('d.m.Y', $postValues['end_date']) : null;
        $poll->anonymous = isset($postValues['anonymous']) && $postValues['anonymous'];
        $poll->front_page = isset($postValues['front_page']) && $postValues['front_page'];
        $poll->active = isset($postValues['active']) && $postValues['active'];
        $poll->save();

        $options = $postValues['poll_fields'];
        foreach ($options as $option) {
            $pollOption = new PollOption();
            $pollOption->poll_id = $poll->id;
            $pollOption->name = $option;
            $pollOption->save();
        }

        $this->updateFrontPagePoll($poll);

        return redirect()
            ->route('poll.index');
    }

    /**
     * @param Poll $poll
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Poll $poll, Request $request)
    {
        $this->validateSaveRequest($poll);
        $hasResults = $poll->results->count();
        $postValues = $request->post();

        $poll->end_date = $postValues['end_date'] ? Carbon::createFromFormat('d.m.Y', $postValues['end_date']) : null;
        $poll->front_page = isset($postValues['front_page']) && $postValues['front_page'];
        $poll->active = isset($postValues['active']) && $postValues['active'];

        if (!$hasResults) {
            $poll->question = $postValues['question'];
            $poll->start_date = Carbon::createFromFormat('d.m.Y', $postValues['start_date']);
            $poll->anonymous = isset($postValues['anonymous']) && $postValues['anonymous'];
        }

        $poll->save();

        if (!$hasResults) {
            $poll->poll_options()->delete();
            $options = $postValues['poll_fields'];
            foreach ($options as $option) {
                $pollOption = new PollOption();
                $pollOption->poll_id = $poll->id;
                $pollOption->name = $option;
                $pollOption->save();
            }
        }

        $this->updateFrontPagePoll($poll);

        return redirect()
            ->route('poll.index');
    }

    /**
     * @param Poll $poll
     * @param Request $request
     * @return Response
     */
    public function show(Poll $poll, Request $request)
    {
        $content = collect()
            ->push(component('Title')
                ->with('title', $poll->question)
            )
            ->push(component('Barchart')
                ->is('black')
                ->with('items', $poll->getFormattedResults())
            )
            ->push(component('Title')
                    ->is('small')
                    ->with('title', trans('poll.answered') . ': ' . $poll->answered)
            )
            ->push(component('Button')
                ->with('title', trans('general.back'))
                ->with('route', route('poll.index'))
            );

        return layout('One')
            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->with('title', trans('poll.results'))
                )
            ))
            ->with('content', $content)
            ->with('footer', region('FooterLight'))
            ->render();
    }

    /**
     * @param Poll $poll
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete(Poll $poll, Request $request)
    {
        $poll->delete();

        return redirect()
            ->route('poll.index');
    }
}

