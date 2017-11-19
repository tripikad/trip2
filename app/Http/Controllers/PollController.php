<?php

namespace App\Http\Controllers;

use Cache;
use App\Poll;
use App\User;
use App\Image;
use App\Content;
use App\PollField;
use App\PollResult;
use App\Destination;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PollController extends Controller
{
    public function search(Request $request)
    {
        $rules = [
            'start' => 'date_format:Y-m-d|before_or_equal:end',
            'end' => 'date_format:Y-m-d',
        ];

        $this->validate($request, $rules);

        $sess_vars = [
            'poll.table.search.name' => $request->input('poll_name', ''),
            'poll.table.search.start' => $request->input('start', ''),
            'poll.table.search.end' => $request->input('end', ''),
            'poll.table.search.active' => $request->input('poll_active', 2),
        ];

        session($sess_vars);

        return $this->index();
    }

    public function getPollTableHeaderItems()
    {
        $header_names = ['id', 'name', 'start_date', 'end_date'];
        $headers = [];
        $sess_order = session('poll.table.order', '');
        $sess_order_type = session('poll.table.order_type', '');

        foreach ($header_names as $name) {
            if ($sess_order == $name && $sess_order_type == 'desc') {
                $type = 'asc';
            } else {
                $type = 'desc';
            }

            $title = trans('content.poll.table.'.str_replace('_date', '', $name));
            if ($name == 'id') {
                $title = 'ID';
            }

            $headers[] = component('Title')
                            ->is('small')
                            ->with('route', route('poll.index', ['order_by' => $name, 'order_type' => $type]))
                            ->with('title', $title);
        }

        $headers[] = component('Title')
                        ->is('small')
                        ->with('title', trans('content.poll.table.active'));

        $headers[] = component('Title')
                        ->is('small')
                        ->with('title', trans('content.poll.table.actions'));

        return $headers;
    }

    protected function getPollTableCellItem($title, $route = null)
    {
        $component = component('MetaLink')
                        ->is('large')
                        ->with('title', $title);

        if ($route !== null) {
            $component->with('route', $route);
        }

        return $component;
    }

    protected function getActionsComponent(Poll $poll)
    {
        $url_name = $poll->poll_results_count == 0 ? 'poll.edit' : 'poll.edit.limited';
        $edit_route = route($url_name, ['id' => $poll->id]);
        $view_route = route('poll.show', ['id' => $poll->id]);

        $meta_items = collect()
            ->push($this->getPollTableCellItem(trans('content.poll.table.view'), $view_route))
            ->push($this->getPollTableCellItem(' / '))
            ->push($this->getPollTableCellItem(trans('content.poll.table.edit'), $edit_route));

        return component('Meta')->with('items', $meta_items);
    }

    public function index()
    {
        $logged_user = request()->user();

        if (request()->has('empty')) {
            session()->forget('poll.table.search');
        }

        $order_by = request()->input('order_by');
        $order_type = request()->input('order_type');

        $polls = Poll::getLatestPagedItems(50, $order_by, $order_type);

        $items = $this->getPollTableHeaderItems();

        foreach ($polls->items() as $item) {
            $items[] = $this->getPollTableCellItem($item->id);
            $items[] = $this->getPollTableCellItem($item->name);
            $items[] = $this->getPollTableCellItem($item->start_date);
            $items[] = $this->getPollTableCellItem($item->end_date);

            $active = $item->content->status == 1 ? trans('content.poll.table.active') : trans('content.poll.table.active.not');
            $items[] = $this->getPollTableCellItem($active);
            $items[] = $this->getActionsComponent($item);
        }

        return layout('2col')
            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('Header', collect()
                ->push(component('Title')
                    ->is('white')
                    ->with('title', trans('content.poll.index.title'))
                    ->with('route', route('poll.index'))
                )
            ))

            ->with('content', collect()

                ->push(
                    component('Grid6')
                        ->with('items', $items)
                )

                ->push(region('Paginator', $polls))
            )

            ->with('sidebar', collect()
                ->push(component('Button')
                    ->is('large')
                    ->with('title', trans('content.poll.create.title'))
                    ->with('route', route('poll.create'))
                )
                ->push(component('Form')
                    ->with('route', route('poll.search'))
                    ->with('fields', collect()
                        ->push(component('Title')
                            ->is('small')
                            ->with('title', trans('content.poll.table.search'))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.name'))
                            ->with('name', 'poll_name')
                            ->with('value', session('poll.table.search.name'))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.start.title'))
                            ->with('name', 'start')
                            ->with('value', session('poll.table.search.start'))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.end.title'))
                            ->with('name', 'end')
                            ->with('value', session('poll.table.search.end'))
                        )
                        ->push(component('FormRadio')
                            ->with('options', [
                                ['id' => 1, 'name' => trans('content.poll.table.active')],
                                ['id' => 0, 'name' => trans('content.poll.table.active.not')],
                            ])
                            ->with('name', 'poll_active')
                            ->with('value', session('poll.table.search.active', 2))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.poll.table.search'))
                        )
                        ->push(component('Button')
                            ->is('transparent')
                            ->with('title', trans('content.poll.table.search.empty'))
                            ->with('route', route('poll.index', ['empty' => 1]))
                        )
                    )
                )
            )

            ->with('footer', region('FooterLight'))
            ->render();
    }

    protected function makeFieldsFromOldQuizRequest()
    {
        $fields = [];
        $quiz_question = old('quiz_question');

        foreach ($quiz_question as $ind => $question) {
            $field = [
                'field_id' => 0,
                'options' => [
                    'question' => $question['question'],
                ],
            ];

            if (isset($question['answer'])) {
                $field['options']['answer'] = is_array($question['answer']) ? array_keys($question['answer']) : $question['answer'];
            }

            if (isset($question['options'])) {
                $options = $question['options'];
                if (isset($options['select_type'])) {
                    $type_p = explode('_', $options['select_type']);
                    unset($options['select_type']);

                    $field['type'] = reset($type_p);
                }
                $field['options']['options'] = $options;
            } else {
                $field['type'] = 'text';
            }

            if (old('old_quiz_photo_'.$ind, false)) {
                $image = Image::findOrFail(old('old_quiz_photo_'.$ind));
                $field['image_small'] = $image->preset('xsmall_square');
                $field['image_large'] = $image->preset('large');
                $field['image_id'] = old('old_quiz_photo_'.$ind);
            }

            $fields[] = $field;
        }

        return $fields;
    }

    protected function makeFieldsFromOldPollRequest()
    {
        $poll_fields = old('poll_fields');

        $field = [
            'field_id' => 0,
            'options' => [
                'question' => old('poll_question'),
                'options' => $poll_fields,
            ],
        ];

        if (isset($poll_fields['select_type'])) {
            $type_p = explode('_', $poll_fields['select_type']);
            unset($poll_fields['select_type']);
            $field['type'] = reset($type_p);
        }

        if (old('old_image_id', false)) {
            $image = Image::findOrFail(old('old_image_id'));
            $field['image_small'] = $image->preset('xsmall_square');
            $field['image_large'] = $image->preset('large');
            $field['image_id'] = old('old_image_id');
        }

        return [$field];
    }

    public function create()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        $fields = [];
        $old_poll_type = old('poll_type', '');
        if (old('poll_fields', false)) {
            $fields = $this->makeFieldsFromOldPollRequest();
        } elseif (old('quiz_question', false)) {
            $fields = $this->makeFieldsFromOldQuizRequest();
        }

        return layout('1col')
            ->with('background', component('BackgroundMap'))
                ->with('color', 'gray')

                ->with('header', region('Header', collect()
                    ->push(component('Title')
                        ->is('white')
                        ->with('title', trans('content.poll.index.title'))
                        ->with('route', route('poll.index'))
                    )
                ))
            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.poll.create.title'))
                )
                ->push(component('Form')
                    ->with('route', route('poll.store'))
                    ->with('files', true)
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.name'))
                            ->with('name', 'poll_name')
                            ->with('value', old('poll_name'))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.start.title'))
                            ->with('name', 'start')
                            ->with('value', old('start'))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.end.title'))
                            ->with('name', 'end')
                            ->with('value', old('end'))
                        )
                        ->push(component('FormSelect')
                            ->with('name', 'destinations')
                            ->with('options', $destinations)
                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                        )
                        ->push(component('Title')
                            ->with('title', trans('content.poll.edit.add.field.title'))
                        )
                        ->push(component('PollAddFields')
                            ->with('value', old('poll_type', Poll::Poll))
                            ->with('fields_json', json_encode($fields, JSON_UNESCAPED_UNICODE))
                            ->with('question_trans', trans('content.poll.edit.question'))
                            ->with('option_trans', trans('content.poll.edit.option'))
                            ->with('poll_trans', trans('content.poll.edit.poll'))
                            ->with('quiz_trans', trans('content.poll.edit.quiz'))
                            ->with('questionnaire_trans', trans('content.poll.edit.questionnaire'))
                            ->with('picture_trans', trans('content.poll.edit.fields.picture'))
                            ->with('select_type_trans', trans('content.poll.edit.option.select.type'))
                            ->with('select_one_trans', trans('content.poll.edit.option.select.one'))
                            ->with('select_multiple_trans', trans('content.poll.edit.option.select.multiple'))
                            ->with('answer_options_trans', trans('content.poll.edit.option.answer.options'))
                            ->with('add_option_trans', trans('content.poll.edit.option.add'))
                            ->with('answer_trans', trans('content.poll.answer.noun'))
                            ->with('option_button_trans', trans('content.poll.edit.options'))
                            ->with('textfield_button_trans', trans('content.poll.edit.textfield'))
                            ->with('show_answers_trans', trans('content.poll.edit.answers'))
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('content.poll.create.active'))
                            ->with('name', 'poll_active')
                            ->with('value', old('poll_active'))
                        )
                        ->push(component('FormButton')
                            ->is('large')
                            ->with('title', trans('content.poll.create.title'))
                        )

                    )
                )
            )
            ->with('footer', region('FooterLight'))
            ->render();
    }

    protected function validateSaveRequest()
    {
        $request = request();

        $rules = [
            'poll_name' => 'required',
            'start' => 'required|date_format:Y-m-d|before_or_equal:end',
            'end' => 'required|date_format:Y-m-d',
            'poll_type' => 'required|in:poll,quiz,questionnaire',
        ];

        $attribute_names = [
            'poll_name' => trans('content.poll.edit.name'),
            'start' => trans('content.poll.edit.field.start.title'),
            'end' => trans('content.poll.edit.field.end.title'),
        ];

        if ($request->poll_type == Poll::Poll) {
            $rules['poll_question'] = 'required';
            $rules['poll_fields.*'] = 'required';
            $rules['poll_fields'] = 'min:2';
            $rules['poll_fields.select_type'] = 'required';

            $attribute_names['poll_question'] = trans('content.poll.edit.question');
            $attribute_names['poll_fields.*'] = trans('content.poll.attribute.poll.fields');
            $attribute_names['poll_fields'] = trans('content.poll.attribute.poll.fields');
            $attribute_names['poll_fields.select_type'] = trans('content.poll.attribute.poll.fields.type');
        } else {
            $rules['quiz_question'] = 'required|min:1';
            $rules['quiz_question.*.type'] = 'required|in:options,textareafield';
            $rules['quiz_question.*.question'] = 'required';

            $attribute_names['quiz_question'] = trans('content.poll.attribute.quiz.questions');
            $attribute_names['quiz_question.*.question'] = trans('content.poll.attribute.quiz.questions');

            if ($request->poll_type == Poll::Quiz) {
                $rules['quiz_question.*.answer'] = 'required';
                $attribute_names['quiz_question.*.answer'] = trans('content.poll.attribute.quiz.answer');
            }

            if ($request->has('quiz_question')) {
                foreach ($request->quiz_question as $index => $arr) {
                    if ($arr['type'] == 'options') {
                        $rules['quiz_question.'.$index.'.options.*'] = 'required';
                        $rules['quiz_question.'.$index.'.options'] = 'required|min:2';
                        $rules['quiz_question.'.$index.'.options.select_type'] = 'required';

                        $attribute_names['quiz_question.'.$index.'.options'] = trans('content.poll.edit.question');
                        $attribute_names['quiz_question.'.$index.'.options.*'] = trans('content.poll.attribute.poll.fields');
                        $attribute_names['quiz_question.'.$index.'.options.select_type'] = trans('content.poll.attribute.poll.fields.type');
                    }

                    if ($arr['type'] == 'options' && $request->poll_type == Poll::Quiz) {
                        $rules['quiz_question.'.$index.'.answer'] = 'required|min:1';
                        $attribute_names['quiz_question.'.$index.'.answer'] = trans('content.poll.attribute.quiz.answer');
                    }
                }
            }
        }

        $validator = \Validator::make($request->all(), $rules);
        $validator->setAttributeNames($attribute_names);
        $validator->validate();
    }

    public function store(Request $request)
    {
        $rules = $this->validateSaveRequest();

        $logged_user = $request->user();
        $poll_type = $request->poll_type;

        $content = $logged_user->contents()->create([
            'title' => $request->poll_name,
            'type' => Poll::Poll,
            'status' => $request->has('poll_active') ? 1 : 0,
        ]);

        if ($request->has('destinations')) {
            $content->destinations()->attach($request->destinations);
        }

        $poll = $content->poll()->create([
            'name' => $request->poll_name,
            'start_date' => $request->start,
            'end_date' => $request->end,
            'type' => $poll_type,
        ]);

        $poll->id = $content->id;

        if ($poll_type == Poll::Poll) {
            $this->addPollFields($poll);
        } elseif ($poll_type == Poll::Quiz || $poll_type == Poll::Questionnaire) {
            $this->addQuizFields($poll);
        }

        return redirect()
            ->route('poll.index');
    }

    protected function addPollFields(Poll $poll)
    {
        $request = request();

        $options = $request->input('poll_fields');
        $type_p = explode('_', $options['select_type']);
        $type = reset($type_p);
        unset($options['select_type']);

        $options = [
            'question' => $request->poll_question,
            'options' => $options,
        ];

        if ($request->hasFile('poll_photo')) {
            $filename = Image::storeImageFile($request->file('poll_photo'));
            $image = Image::create(['filename' => $filename]);
            $options['image_id'] = $image->id;
        } elseif ($request->has('old_image_id')) {
            $options['image_id'] = $request->old_image_id;
        }

        $poll->poll_fields()->create([
            'type' => $type,
            'options' => json_encode($options),
        ]);
    }

    protected function addQuizFields(Poll $poll)
    {
        $request = request();
        $fields = [];

        foreach ($request->quiz_question as $index => $question) {
            $options = [
                'question' => $question['question'],
                'show_answers' => $request->has('quiz_show_answers') ? 1 : 0,
            ];

            if (isset($question['answer']) && is_array($question['answer'])) {
                $options['answer'] = array_keys($question['answer']);
            } elseif (isset($question['answer'])) {
                $options['answer'] = $question['answer'];
            }

            $photo_field = 'quiz_photo_'.$index;
            if ($request->hasFile($photo_field)) {
                $filename = Image::storeImageFile($request->file($photo_field));
                $image = Image::create(['filename' => $filename]);
                $options['image_id'] = $image->id;
            } elseif ($request->has('old_'.$photo_field)) {
                $old_photo_field = 'old_'.$photo_field;
                $options['image_id'] = $request->$old_photo_field;
            }

            $type = $question['type'];
            if ($type == 'options') {
                $opts = $question['options'];
                $type_p = explode('_', $opts['select_type']);
                $type = reset($type_p);
                unset($opts['select_type']);

                $options['options'] = $opts;
            } else {
                $type = 'text';
            }

            $fields[] = [
                'type' => $type,
                'options' => json_encode($options),
            ];
        }

        $poll->poll_fields()->createMany($fields);
    }

    protected function makeTextResultGrid(&$parsed_results)
    {
        $grid_items = collect();

        foreach ($parsed_results as $index => $result) {
            if ($result['value'] < 10) {
                $grid_items->push(component('MetaLink')->is('smaller')->with('title', $result['title']));
                $grid_items->push(component('MetaLink')->is('smaller')->with('title', $result['value'].'%'));

                unset($parsed_results[$index]);
            }
        }

        if ($grid_items->count() >= 10) {
            $grid_items->prepend(component('Title')->is('smaller')->with('title', 'Vastus'));
            $grid_items->prepend(component('Title')->is('smaller')->with('title', 'Protsent'));
        }

        if ($grid_items->isNotEmpty()) {
            $grid_items->prepend(component('Title')->is('smaller')->with('title', 'Vastus'));
            $grid_items->prepend(component('Title')->is('smaller')->with('title', 'Protsent'));
        }

        return $grid_items;
    }

    protected function makeUserScoreGrid(Poll $poll)
    {
        $users = [];
        $field_answers = [];

        foreach ($poll->poll_fields->getIterator() as $index => $field) {
            $options = json_decode($field->options, true);
            $id = $field->field_id;
            $type = $field->type;

            if ($type == 'text') {
                $field_answers[$id] = mb_strtolower($options['answer']);
            } else {
                $field_answers[$id] = is_array($options['answer']) ? $options['answer'] : [$options['answer']];
            }
        }

        foreach ($poll->poll_results->getIterator() as $index => $result) {
            $user_answer = json_decode($field->result, true);
            $user_id = $result->user_id;
            $answer = $field_answers[$result->field_id];

            if (is_array($answer) && ! is_array($user_answer)) {
                $user_answer = [$user_answer];
            }

            if (! isset($users[$user_id])) {
                $users[$user_id] = 0;
            }

            if (is_array($answer) && count(array_intersect($user_answer, $answer)) == count($answer)) {
                $users[$user_id]++;
            } elseif (! is_array($answer) && $answer == mb_strtolower($user_answer)) {
                $users[$user_id]++;
            }
        }

        asort($users, SORT_NUMERIC);
        $user_scores = collect();

        $index = 0;
        foreach ($users as $user_id => $score) {
            $user = User::find($user_id);

            $user_scores->push(component('MetaLink')->is('smaller')->with('title', ++$index.'. '.$user->name));
            $user_scores->push(component('MetaLink')->is('smaller')->with('title', $score));
        }

        return $user_scores;
    }

    public function show($id)
    {
        $poll = Poll::getPollById($id);

        $total_people_ans = $poll->poll_results_count / $poll->poll_fields_count;

        $content = collect()
            ->push(component('Title')
                ->with('title', $poll->name)
            );

        if ($total_people_ans > 0) {
            foreach ($poll->poll_fields->getIterator() as $index => $field) {
                $options = json_decode($field->options, true);
                $question = $options['question'];
                $type = $field->type;

                $content->push(
                    component('Title')
                        ->is('small')
                        ->with('title', ($index + 1).'. '.$question)
                );

                $parsed_results = $field->getParsedResults();

                if ($type == 'text') {
                    $grid_items = $this->makeTextResultGrid($parsed_results);
                }

                $content->push(
                    component('Barchart')
                        ->is('black')
                        ->with('items', $parsed_results)
                );

                if (isset($grid_items) && $grid_items->isNotEmpty()) {
                    $component = $grid_items->count() >= 14 ? 'Grid4' : 'Grid2';

                    $content->push(
                        component($component)
                            ->with('items', $grid_items)
                    );
                }
            }
        }

        $content->push(
                component('Title')
                    ->is('small')
                    ->with('title', trans('content.poll.show.user.count', ['count' => $total_people_ans]))
            );

        if ($total_people_ans > 0 && $poll->type == Poll::Quiz) {
            $content->push(
                component('Grid4')
                    ->with('items', $this->makeUserScoreGrid($poll))
            );
        }

        return layout('1col')
            ->with('background', component('BackgroundMap'))
                ->with('color', 'gray')

                ->with('header', region('Header', collect()
                    ->push(component('Title')
                        ->is('white')
                        ->with('title', trans('content.poll.show.title'))
                    )
                ))
            ->with('content', $content)
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function edit($id)
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        $poll = Poll::getPollById($id);

        if ($poll->poll_results_count != 0) {
            return redirect()->route('poll.index');
        }

        $content_rels = $poll->content->getRelations();
        $dests = $content_rels['destinations'];
        $dest_id = null;
        if ($dests->isNotEmpty()) {
            $dest_id = $dests->first()->id;
        }

        $poll_fields = [];

        if (old('poll_fields', false)) {
            $poll_fields = $this->makeFieldsFromOldPollRequest();
        } elseif (old('quiz_question', false)) {
            $poll_fields = $this->makeFieldsFromOldQuizRequest();
        } else {
            foreach ($poll->poll_fields->all() as $field) {
                $options = json_decode($field->options, true);

                $poll_field = [
                    'type' => $field->type,
                    'field_id' => $field->field_id,
                    'options' => $options,
                ];

                if (isset($options['image_id'])) {
                    $image = Image::findOrFail($options['image_id']);
                    $poll_field['image_small'] = $image->preset('xsmall_square');
                    $poll_field['image_large'] = $image->preset('large');
                    $poll_field['image_id'] = $options['image_id'];
                }

                $poll_fields[] = $poll_field;
            }
        }

        return layout('1col')
            ->with('background', component('BackgroundMap'))
                ->with('color', 'gray')

                ->with('header', region('Header', collect()
                    ->push(component('Title')
                        ->is('white')
                        ->with('title', trans('content.poll.index.title'))
                        ->with('route', route('poll.index'))
                    )
                ))
            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.poll.edit.title'))
                )
                ->push(component('Form')
                    ->with('route', route('poll.update', ['id' => $poll->id]))
                    ->with('files', true)
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.name'))
                            ->with('name', 'poll_name')
                            ->with('value', old('poll_name', $poll->name))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.start.title'))
                            ->with('name', 'start')
                            ->with('value', old('start', $poll->start_date))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.end.title'))
                            ->with('name', 'end')
                            ->with('value', old('end', $poll->end_date))
                        )
                        ->push(component('FormSelect')
                            ->with('name', 'destinations')
                            ->with('options', $destinations)
                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                            ->with('value', old('destinations', $dest_id))
                        )
                        ->push(component('Title')
                            ->with('title', trans('content.poll.edit.add.field.title'))
                        )
                        ->push(component('PollAddFields')
                            ->with('value', $poll->type)
                            ->with('fields_json', json_encode($poll_fields, JSON_UNESCAPED_UNICODE))
                            ->with('question_trans', trans('content.poll.edit.question'))
                            ->with('option_trans', trans('content.poll.edit.option'))
                            ->with('poll_trans', trans('content.poll.edit.poll'))
                            ->with('quiz_trans', trans('content.poll.edit.quiz'))
                            ->with('questionnaire_trans', trans('content.poll.edit.questionnaire'))
                            ->with('picture_trans', trans('content.poll.edit.fields.picture'))
                            ->with('select_type_trans', trans('content.poll.edit.option.select.type'))
                            ->with('select_one_trans', trans('content.poll.edit.option.select.one'))
                            ->with('select_multiple_trans', trans('content.poll.edit.option.select.multiple'))
                            ->with('answer_options_trans', trans('content.poll.edit.option.answer.options'))
                            ->with('add_option_trans', trans('content.poll.edit.option.add'))
                            ->with('answer_trans', trans('content.poll.answer.noun'))
                            ->with('option_button_trans', trans('content.poll.edit.options'))
                            ->with('textfield_button_trans', trans('content.poll.edit.textfield'))
                            ->with('show_answers_trans', trans('content.poll.edit.answers'))
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('content.poll.create.active'))
                            ->with('name', 'poll_active')
                            ->with('value', old('poll_active', $poll->content->status))
                        )
                        ->push(component('FormButton')
                            ->is('large')
                            ->with('title', trans('content.poll.edit.title'))
                        )

                    )
                )
            )
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function update(Request $request, $id)
    {
        $this->validateSaveRequest();

        $poll_type = $request->poll_type;

        $content = Content::findOrFail($id);
        $poll = Poll::findOrFail($id);

        if ($poll->poll_results()->get()->count() != 0) {
            return redirect()->route('poll.index');
        }

        $content->fill([
            'title' => $request->poll_name,
            'type' => Poll::Poll,
            'status' => $request->has('poll_active') ? 1 : 0,
        ])
        ->save();

        $poll->fill([
            'name' => $request->poll_name,
            'start_date' => $request->start,
            'end_date' => $request->end,
            'type' => $poll_type,
        ])
        ->save();

        PollField::where('poll_id', $id)->delete();

        if ($poll_type == Poll::Poll) {
            $this->addPollFields($poll);
        } elseif ($poll_type == Poll::Quiz || $poll_type == Poll::Questionnaire) {
            $this->addQuizFields($poll);
        }

        return redirect()
            ->route('poll.index');
    }

    protected function limitedEditFields($poll_fields)
    {
        $fields = collect();

        foreach ($poll_fields->getIterator() as $index => $field) {
            $options = json_decode($field->options, true);
            $type = $field->type;

            $fields->push(
                component('Title')
                    ->is('small')
                    ->with('title', ($index + 1).'. '.$options['question'])
            );

            if (isset($options['image_id'])) {
                $image = Image::findOrFail($options['image_id']);
                $fields->push(
                    component('PhotoCard')
                        ->with('small', $image->preset('large'))
                        ->with('large', $image->preset('large'))
                );
            }

            if ($type == 'checkbox' || $type == 'radio') {
                if (isset($options['answer'])) {
                    $answer = is_array($options['answer']) ? $options['answer'] : [$options['answer']];
                } else {
                    $answer = [];
                }

                $fields->push(component('QuizOptionRow')
                    ->with('type', $type)
                    ->with('answer', $answer)
                    ->with('user_answer', $answer)
                    ->with('options', $options['options'])
                );
            } elseif (isset($options['answer']) && $type == 'text') {
                $answer = $options['answer'];

                $fields->push(component('QuizTextRow')
                    ->with('answer', mb_strtolower($answer))
                    ->with('user_answer', mb_strtolower($answer))
                    ->with('value', $answer)
                );
            }
        }

        return $fields;
    }

    public function limitedEdit($id)
    {
        $poll = Poll::getPollById($id);

        $content_rels = $poll->content->getRelations();
        $dests = $content_rels['destinations'];
        $dest_id = null;
        $dest_name = '';
        if ($dests->isNotEmpty()) {
            $dest_id = $dests->first()->id;
            $dest_name = $dests->first()->name;
        }

        return layout('1col')
            ->with('background', component('BackgroundMap'))
                ->with('color', 'gray')

                ->with('header', region('Header', collect()
                    ->push(component('Title')
                        ->is('white')
                        ->with('title', trans('content.poll.index.title'))
                        ->with('route', route('poll.index'))
                    )
                ))
            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.poll.edit.title'))
                )
                ->push(component('Form')
                    ->with('route', route('poll.update.limited', ['id' => $poll->id]))
                    ->with('files', true)
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.name'))
                            ->with('name', 'poll_name')
                            ->with('value', old('poll_name', $poll->name))
                            ->with('disabled', true)
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.start.title'))
                            ->with('name', 'start')
                            ->with('value', old('start', $poll->start_date))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.end.title'))
                            ->with('name', 'end')
                            ->with('value', old('end', $poll->end_date))
                        )
                        ->pushWhen($dest_id, component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.destination'))
                            ->with('name', 'destinations')
                            ->with('value', $dest_name)
                            ->with('disabled', true)
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('content.poll.create.active'))
                            ->with('name', 'poll_active')
                            ->with('value', old('poll_active', $poll->content->status))
                        )
                        ->push(component('FormButton')
                            ->is('large')
                            ->with('title', trans('content.poll.edit.title'))
                        )

                    )
                )
                ->push(component('Title')
                    ->with('title', trans('content.poll.edit.limited.fields'))
                )
                ->merge($this->limitedEditFields($poll->poll_fields))
            )
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function limitedUpdate(Request $request, $id)
    {
        $request = request();

        $rules = [
            'start' => 'required|date_format:Y-m-d|before_or_equal:end',
            'end' => 'required|date_format:Y-m-d',
        ];

        $attribute_names = [
            'start' => trans('content.poll.edit.field.start.title'),
            'end' => trans('content.poll.edit.field.end.title'),
        ];

        $validator = \Validator::make($request->all(), $rules);
        $validator->setAttributeNames($attribute_names);
        $validator->validate();

        $poll_type = $request->poll_type;

        $content = Content::findOrFail($id);
        $poll = Poll::findOrFail($id);

        $content->fill([
            'status' => $request->has('poll_active') ? 1 : 0,
        ])
        ->save();

        $poll->fill([
            'start_date' => $request->start,
            'end_date' => $request->end,
        ])
        ->save();

        return redirect()
            ->route('poll.index');
    }

    public function answerPoll(Request $request)
    {
        $rules = [
            'id' => 'required',
            'values' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $poll = Poll::getPollById($request->id);
        $poll_field = $poll->poll_fields->first();
        $logged_user = request()->user();

        $values = $request->values;
        if (! is_array($values)) {
            $values = [$values];
        }

        try {
            PollResult::where('field_id', $poll_field->field_id)
                ->where('user_id', $logged_user->id)
                ->firstOrFail();
        } catch (ModelNotFoundException $ex) {
            $poll_result = $poll->poll_results()->create([
                'field_id' => $poll_field->field_id,
                'user_id' => $logged_user->id,
                'result' => json_encode($values),
            ]);
        }

        $results = $poll_field->getParsedResults();

        $poll = Poll::getPollById($request->id);
        $count = $poll->poll_results_count / $poll->poll_fields_count;

        Cache::put('poll_'.$poll->id.'_results', json_encode($results), Poll::CacheTTL);
        Cache::put('poll_'.$poll->id.'_count', $count, Poll::CacheTTL);

        return ['result' => $results, 'count' => $count];
    }

    public function showQuizOrQuestionnaire($slug)
    {
        $quiz = Poll::getPollBySlug($slug);

        $logged_user = request()->user();

        $quiz_result = $quiz->poll_results()->where('user_id', $logged_user->id)->get();

        $content = collect()
            ->push(component('Title')
                ->with('title', $quiz->name)
            );

        if ($quiz_result->isEmpty()) {
            $content->push($this->getQuizOrQuestionnaireAnswerFormComponent($quiz));
        } elseif ($quiz->type == Poll::Quiz) {
            $content = $content->merge($this->getQuizAnswerResultComponent($quiz));
        } elseif ($quiz->type == Poll::Questionnaire) {
            return redirect()
                ->route('frontpage.index');
        }

        return layout('1col')
            ->with('background', component('BackgroundMap'))
                ->with('color', 'gray')

                ->with('header', region('Header', collect()
                    ->push(component('Title')
                        ->is('white')
                        ->with('title', trans('content.poll.edit.quiz'))
                    )
                ))
            ->with('content', $content)
            ->with('footer', region('Footer'))
            ->render();
    }

    public function getQuizOrQuestionnaireAnswerFormComponent(Poll $quiz)
    {
        $fields = collect();

        foreach ($quiz->poll_fields->getIterator() as $index => $field) {
            $options = json_decode($field->options, true);
            $question = $options['question'];
            $type = $field->type;

            $fields->push(
                component('Title')
                    ->is('small')
                    ->with('title', ($index + 1).'. '.$question)
            );

            if (isset($options['image_id'])) {
                $image = Image::findOrFail($options['image_id']);
                $fields->push(
                    component('PhotoCard')
                        ->with('small', $image->preset('large'))
                        ->with('large', $image->preset('large'))
                );
            }

            if ($type == 'text') {
                $fields->push(
                    component('FormTextfield')
                        ->with('name', sprintf('quiz_answer[%d]', $field->field_id))
                        ->with('placeholder', trans('content.poll.answer.noun'))
                );
            } elseif ($type == 'radio') {
                foreach ($options['options'] as $opt) {
                    $fields->push(
                        component('FormRadio')
                            ->with('name', sprintf('quiz_answer[%d]', $field->field_id))
                            ->with('options', [['id' => $opt, 'name' => $opt]])
                    );
                }
            } elseif ($type == 'checkbox') {
                foreach ($options['options'] as $opt) {
                    $fields->push(
                        component('FormCheckbox')
                            ->with('name', sprintf('quiz_answer[%d][%s]', $field->field_id, $opt))
                            ->with('title', $opt)
                    );
                }
            }
        }

        return component('Form')
                    ->with('route', route('quiz.answer', ['slug' => $quiz->content->slug]))
                    ->with('fields', $fields
                        ->push(component('FormButton')
                            ->is('large')
                            ->with('title', trans('content.poll.answer'))
                        )
                    );
    }

    public function getQuizAnswerResultComponent(Poll $quiz)
    {
        $fields = collect();

        $correct = 0;

        foreach ($quiz->poll_fields->getIterator() as $index => $field) {
            $options = json_decode($field->options, true);
            $type = $field->type;
            $show_answers = isset($options['show_answers']) && $options['show_answers'];

            $poll_result = $field->poll_results()
                ->where('user_id', request()->user()->id)
                ->get()
                ->first();
            $user_answer = json_decode($poll_result->result, true);

            if ($type == 'checkbox' || $type == 'radio') {
                $answers = is_array($options['answer']) ? $options['answer'] : [$options['answer']];
                $user_answer = is_array($user_answer) ? $user_answer : [$user_answer];

                if (count(array_intersect($user_answer, $answers)) == count($answers)) {
                    $correct++;
                }
            } elseif ($type == 'text' && mb_strtolower($options['answer']) == mb_strtolower($user_answer)) {
                $correct++;
            }

            if (! $show_answers) {
                continue;
            }

            $question = $options['question'];

            $fields->push(
                component('Title')
                    ->is('small')
                    ->with('title', ($index + 1).'. '.$question)
            );

            if (isset($options['image_id'])) {
                $image = Image::findOrFail($options['image_id']);
                $fields->push(
                    component('PhotoCard')
                        ->with('small', $image->preset('large'))
                        ->with('large', $image->preset('large'))
                );
            }

            if ($type == 'checkbox' || $type == 'radio') {
                $fields->push(component('QuizOptionRow')
                    ->with('type', $type)
                    ->with('answer', $answers)
                    ->with('user_answer', $user_answer)
                    ->with('options', $options['options'])
                );
            } elseif ($type == 'text') {
                $fields->push(component('QuizTextRow')
                    ->with('answer', mb_strtolower($options['answer']))
                    ->with('user_answer', mb_strtolower($user_answer))
                    ->with('value', $user_answer)
                );
            }
        }

        $fields->prepend(
            component('Title')
                ->is('small')
                ->with('title', trans('content.poll.show.user.correct', ['correct' => $correct, 'all' => $quiz->poll_fields->count()]))
        );

        $fields->push(component('Button')
            ->is('large')
            ->with('title', trans('content.poll.show.redirect.index'))
            ->with('route', route('frontpage.index'))
        );

        return $fields;
    }

    public function answerQuiz(Request $request, $slug)
    {
        $quiz = Poll::getPollBySlug($slug);

        $logged_user = $request->user();
        $results = [];
        $rules = [
            'quiz_answer' => 'required',
            'quiz_answer.*' => 'required',
        ];

        foreach ($quiz->poll_fields->getIterator() as $index => $field) {
            $result = [
                'field_id' => $field->field_id,
                'user_id' => $logged_user->id,
            ];

            if ($field->type == 'checkbox') {
                $rules['quiz_answer.'.$field->field_id] = 'min:1';
                $rules['quiz_answer.'.$field->field_id.'.*'] = 'required';

                $lowercase_asnwer = array_map('mb_strtolower', array_keys($request->input('quiz_answer.'.$field->field_id)));
                $result['result'] = json_encode($lowercase_asnwer);
            } else {
                $answer = $request->input('quiz_answer.'.$field->field_id);

                if (is_array($answer)) {
                    $lowercase_answer = array_map('mb_strtolower', $answer);
                } else {
                    $lowercase_answer = mb_strtolower($answer);
                }

                $result['result'] = json_encode($lowercase_answer);
            }

            $results[] = $result;
        }

        $this->validate(request(), $rules);

        $quiz->poll_results()->createMany($results);

        if ($quiz->type == Poll::Questionnaire) {
            return redirect()
                ->route('frontpage.index');
        }

        return redirect()
            ->route('quiz.answer', ['slug' => $quiz->content->slug]);
    }
}
