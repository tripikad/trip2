<?php

namespace App\Http\Controllers;

class V2AuthController extends Controller
{
    public function loginFormExperiment()
    {
        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('auth.login.title'))
                )
                ->push('&nbsp;')
                ->push(component('Title')
                    ->is('center')
                    ->is('small')
                    ->with('title', trans('auth.login.not.registered',
                        ['link' => createlink(route('register.form'), trans('auth.login.not.registered.link.title'))]
                    ))
                )
            )

            ->with('content_top', component('Grid3')->with('items', collect()
                ->push(component('AuthTab')
                    ->with('title', trans('auth.login.field.name.title'))
                )
                ->push(component('AuthTab')
                    ->is('facebook')
                    ->with('route', route('facebook.redirect'))
                    ->with('title', 'Facebook')
                )
                ->push(component('AuthTab')
                    ->is('google')
                    ->with('route', route('google.redirect'))
                    ->with('title', 'Google')
                )
            ))

            ->with('content', collect()
                ->push(component('Form')->with('fields', collect()
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', trans('auth.login.field.name.title'))
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', trans('auth.login.field.password.title'))
                    )
                    ->push(component('FormCheckbox')
                        ->with('name', 'remember')
                        ->with('title', trans('auth.login.field.remember.title'))
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->with('title', trans('auth.login.submit.title'))
                    )
                ))
            )

            ->with('bottom', collect()->push(component('MetaLink')
                ->with('title', trans('auth.login.not.rembeber.pw',
                    ['link' => createlink(route('reset.apply.form'), trans('auth.reset.apply.title.link'))])
                )
            ))

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function registerFormExperiment()
    {
        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('auth.register.title'))
                )
                ->push('&nbsp;')
                ->push(component('Title')
                    ->is('center')
                    ->is('small')
                    ->with('title', trans('auth.register.subhead.title'))
                )
            )

            ->with('content_top', component('Grid3')->with('items', collect()
                ->push(component('AuthTab')
                    ->with('title', 'E-mailiga')
                )
                ->push(component('AuthTab')
                    ->is('facebook')
                    ->with('route', route('facebook.redirect'))
                    ->with('title', 'Facebook')
                )
                ->push(component('AuthTab')
                    ->is('google')
                    ->with('route', route('google.redirect'))
                    ->with('title', 'Google')
                )
            ))

            ->with('content', collect()
                ->push(component('Form')->with('fields', collect()
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', trans('auth.register.field.name.title'))
                    )
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', trans('auth.register.field.email.title'))
                    )
                    ->push(component('FormPassword')
                        ->with('title', trans('auth.register.field.password.title'))
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', trans('auth.register.field.password_confirmation.title'))
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->with('title', trans('auth.register.submit.title'))
                    )
                ))
            )

            ->with('bottom', collect()->push(component('MetaLink')
                ->with('title', trans('auth.register.field.eula.title', [
                    'link' => createlink(route('static.show.id', [25151]), trans('auth.register.field.eula.title.link'))
                ]))
            ))

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function passwordFormExperiment()
    {
        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('auth.reset.apply.title'))
                )
                ->push('&nbsp;')
                ->push(component('Title')
                    ->is('center')
                    ->is('small')
                    ->with('title', trans('auth.reset.apply.subtitle'))
                )
            )

            ->with('content', collect()
                ->push(component('Form')->with('fields', collect()
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', trans('auth.reset.apply.field.email.title'))
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->with('title', trans('auth.reset.apply.submit.title'))
                    )
                ))
            )

            ->with('bottom', collect()->push(component('MetaLink')
                ->with('title', trans('auth.reset.login.title', [
                    'link' => createlink(route('login.form'), trans('auth.reset.login.link.title'))
                ]))
            ))

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function resetFormExperiment()
    {
        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('auth.reset.password.title'))
                )
            )

            ->with('content', collect()
                ->push(component('Form')->with('fields', collect()
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', trans('auth.reset.password.field.email.title'))
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', trans('auth.reset.password.field.password.title'))
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', trans('auth.reset.password.field.password_confirmation.title'))
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->with('title', trans('auth.reset.password.submit.title'))
                    )
                ))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }
}
