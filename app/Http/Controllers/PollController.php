<?php

namespace App\Http\Controllers;

use App\Image;
use App\Poll;
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
                            ->with('value', old('poll_name', 'test_name'))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.start.title'))
                            ->with('name', 'start')
                            ->with('value', old('start', '2017-01-07'))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.end.title'))
                            ->with('name', 'end')
                            ->with('value', old('end', '2017-01-08'))
                        )
                        ->push(component('FormSelect')
                            ->with('name', 'destinations')
                            ->with('options', $destinations)
                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                            ->with('value', 1033)
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

    protected function parseOptions(Request $request, $prefix)
    {
        $options = [];
        $cnt = $prefix.'_cnt';

        for ($i = 1; $i <= $request->$cnt; $i++) {
            $opt = $prefix.'_'.$i;
            if (isset($request->$opt) && ! empty($request->$opt)) {
                $options[] = $request->$opt;
            }
        }

        return $options;
    }

    protected function addPollFields(Request $request, Poll $poll)
    {
        $type = $request->poll_fields_select_type == 'select_one' ? 'radio' : 'checkbox';

        $options = [
            'question' => $request->poll_question,
            'options' => $this->parseOptions($request, 'poll_fields'),
        ];

        if($request->hasFile('poll_photo'))
        {
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

        for ($i = 1; $i <= $request->quiz_question_cnt; $i++) {
            $type_field = 'quiz_question_'.$i;
            $answer_field = $type_field.'_answer';
            $question_field = $type_field.'_question';

            if (! isset($request->$type_field) || empty($request->$question_field) || empty($request->$answer_field)) {
                continue;
            }

            $options = [
                'question' => $request->$question_field,
                'answer' => $request->$answer_field,
            ];

            $photo_field = $type_field . '_photo';
            if($request->hasFile($photo_field))
            {
                $filename = Image::storeImageFile($request->file($photo_field));
                $image = Image::create(['filename' => $filename]);
                $options['image_id'] = $image->id;
            }

            $type = $request->$type_field;
            if ($type == 'options') {
                $select_type = $type_field.'_select_type';
                $type = $request->$select_type == 'select_one' ? 'radio' : 'checkbox';

                $options['options'] = $this->parseOptions($request, $type_field);
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
