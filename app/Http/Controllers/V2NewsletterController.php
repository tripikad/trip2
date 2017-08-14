<?php

namespace App\Http\Controllers;

use App\NewsletterType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;

class V2NewsletterController extends Controller
{
    public function index()
    {
        $newsletter_types = NewsletterType::all();

        $navBar = collect();

        foreach ($newsletter_types as &$newsletter_type) {
            if (strpos($newsletter_type->subject, '%destination_name') !== false) {
                $newsletter_type->subject = str_replace('%destination_name', '...', $newsletter_type->subject);
            }

            $navBar->push(component('Button')
                ->with('title', $newsletter_type->subject)
                ->with('route', route('newsletter.view', [$newsletter_type]))
            );
        }

        return layout('1col')
            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')
            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('menu.admin.newsletter'))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))
            ->with('content', $navBar)
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function view($id)
    {
        $newsletter = NewsLetterType::findOrFail($id);
        if (strpos($newsletter->subject, '%destination_name') !== false) {
            $newsletter->subject = str_replace('%destination_name', '...', $newsletter->subject);
        }

        $newsletter_types = NewsletterType::all();
        $navBar = collect();

        foreach ($newsletter_types as &$newsletter_type) {
            if (strpos($newsletter_type->subject, '%destination_name') !== false) {
                $newsletter_type->subject = str_replace('%destination_name', '...', $newsletter_type->subject);
            }

            $navBar->push(component('Button')
                ->with('title', $newsletter_type->subject)
                ->with('route', route('newsletter.view', [$newsletter_type]))
            );
        }

        return layout('2col')
            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')
            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->with('title', trans('newsletter.title') . ': ' . $newsletter->subject)
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))
            ->with('content', 'To-do: Uudiskirjade nimekiri koos infoga tuleb siia')
            ->with('sidebar', $navBar)
            ->with('footer', region('FooterLight'))
            ->render();
    }

    public function edit($id)
    {

    }

    public function store(Request $request, $id)
    {
        
    }

    public function preview($id)
    {
        $markdown = new Markdown(view(), config('mail.markdown'));

        return $markdown->render('email.newsletter.long_time_ago', [
            'unsubscribe_id' => 4,
        ]);
    }
}
