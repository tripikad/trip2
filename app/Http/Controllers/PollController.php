<?php

namespace App\Http\Controllers;

use App\Poll;
use App\Image;
use App\Destination;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
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
            ->with('sidebar', collect()
                ->push(component('Block')
                    ->is('gray')
                    ->with('content', collect()
                        ->push(component('Title')
                            ->is('smaller')
                            ->is('red')
                            ->with('title', trans('content.edit.notes.heading'))
                            ->with('route', route('forum.index'))
                        )
                        ->push(component('Body')
                            ->with('body', trans('content.edit.notes.body'))
                        )
                ))
            )
            ->with('footer', region('Footer'))
            ->render();
    }

    public function create()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

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
                            ->with('value', old('poll_type', 'poll'))
                            ->with('question_trans', trans('content.poll.edit.question'))
                            ->with('option_trans', trans('content.poll.edit.option'))
                            ->with('poll_trans', trans('content.poll.edit.poll'))
                            ->with('quiz_trans', trans('content.poll.edit.quiz'))
                            ->with('picture_trans', trans('content.poll.edit.fields.picture'))
                            ->with('select_type_trans', trans('content.poll.edit.option.select.type'))
                            ->with('select_one_trans', trans('content.poll.edit.option.select.one'))
                            ->with('select_multiple_trans', trans('content.poll.edit.option.select.multiple'))
                            ->with('answer_options_trans', trans('content.poll.edit.option.answer.options'))
                            ->with('add_option_trans', trans('content.poll.edit.option.add'))
                        )
                        ->push(component('FormCheckbox')
                            ->with('title', trans('content.poll.create.active'))
                            ->with('name', 'poll_active')
                        )
                        ->push(component('FormButton')
                            ->is('large')
                            ->with('title', trans('content.poll.create.title'))
                        )

                    )
                )
            )
            ->with('footer', region('Footer'))
            ->render();
    }

    public function store(Request $request)
    {
        $rules = [
            'poll_name' => 'required',
            'start' => ['required', 'regex:/^([0-9]{4})-?(1[0-2]|0[1-9])-?(3[01]|0[1-9]|[12][0-9])$/'],
            'end' => ['required', 'regex:/^([0-9]{4})-?(1[0-2]|0[1-9])-?(3[01]|0[1-9]|[12][0-9])$/'],
            'destinations' => 'required',
            'poll_type' => 'in:poll,quiz',
        ];

        if ($request->poll_type == 'poll') {
            $rules['poll_question'] = 'required';
            $rules['poll_fields.*'] = 'required';
            $rules['poll_fields'] = 'min:2';
            $rules['poll_fields.select_type'] = 'in:select_multiple,select_one';
        } else {
            $rules['quiz_question'] = 'required|min:1';
            $rules['quiz_question.*.type'] = 'required|in:options,textareafield';
            $rules['quiz_question.*.question'] = 'required';
            $rules['quiz_question.*.answer'] = 'required';

            if ($request->has('quiz_question')) {
                foreach ($request->quiz_question as $index => $arr) {
                    if ($arr['type'] == 'options') {
                        $rules['quiz_question.'.$index.'.options.*'] = 'required';
                        $rules['quiz_question.'.$index.'.options'] = 'required|min:2';
                        $rules['quiz_question.'.$index.'.select_type'] = 'in:select_multiple,select_one';
                    }
                }
            }
        }

        $this->validate(request(), $rules);

        $logged_user = $request->user();
        $poll_type = $request->poll_type;

        $content = $logged_user->contents()->create([
            'title' => $request->poll_name,
            'type' => $poll_type,
            'status' => $request->has('poll_active') ? 1 : 0,
        ]);

        $content->destinations()->attach(request()->destinations);

        $poll = $content->poll()->create([
            'name' => $request->poll_name,
            'start_date' => $request->start,
            'end_date' => $request->end,
            'type' => $poll_type,
        ]);

        $poll->id = $content->id;

        if ($poll_type == 'poll') {
            $this->addPollFields($request, $poll);
        } elseif ($poll_type == 'quiz') {
            $this->addQuizFields($request, $poll);
        }

        return redirect()
            ->route('poll.index');
    }

    protected function addPollFields(Request $request, Poll $poll)
    {
        $options = $request->input('poll_fields');
        $type = $options['select_type'] == 'select_one' ? 'radio' : 'checkbox';
        unset($options['select_type']);

        $options = [
            'question' => $request->poll_question,
            'options' => $options,
        ];

        if ($request->hasFile('poll_photo')) {
            $filename = Image::storeImageFile($request->file('poll_photo'));
            $image = Image::create(['filename' => $filename]);
            $options['image_id'] = $image->id;
        }

        $poll->poll_fields()->create([
            'type' => $type,
            'options' => json_encode($options),
        ]);
    }

    protected function addQuizFields(Request $request, Poll $poll)
    {
        $fields = [];

        foreach ($request->quiz_question as $index => $question) {
            $options = [
                'question' => $question['question'],
                'answer' => $question['answer'],
            ];

            $photo_field = 'quiz_photo_'.$index;
            if ($request->hasFile($photo_field)) {
                $filename = Image::storeImageFile($request->file($photo_field));
                $image = Image::create(['filename' => $filename]);
                $options['image_id'] = $image->id;
            }

            $type = $question['type'];
            if ($type == 'options') {
                $opts = $question['options'];
                $type = $opts['select_type'] == 'select_one' ? 'radio' : 'checkbox';
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
