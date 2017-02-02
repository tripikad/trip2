<?php

namespace App\Http\Controllers;

class V2AuthController extends Controller
{
    public function loginForm()
    {
        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('Logi sisse'))
                )
                ->push('&nbsp;')
                ->push(component('Title')
                    ->is('center')
                    ->is('small')
                    ->with('title', trans('Pole veel kasutaja? Registreeri siin'))
                )
            )

            ->with('content_top', component('Grid3')->with('items', collect()
                ->push(component('AuthTab')
                    ->with('title', 'Kasutajanimi')
                )
                ->push(component('AuthTab')
                    ->is('facebook')
                    ->with('title', 'Facebook')
                )
                ->push(component('AuthTab')
                    ->is('google')
                    ->with('title', 'Google')
                )
            ))

            ->with('content', collect()
                ->push(component('Form')->with('fields', collect()
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'Kasutajanimi')
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', 'Parool')
                    )
                    ->push(component('FormCheckbox')
                        ->with('name', 'remember')
                        ->with('title', 'Jäta mind meelde')
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->with('title', 'Logi sisse')
                    )
                ))
            )

            ->with('bottom', collect()->push(component('MetaLink')
                ->with('title', 'Ei mäleta parooli? Taasta parool siin')
            ))

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function registerForm()
    {
        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', trans('Registreeri'))
                )
                ->push('&nbsp;')
                ->push(component('Title')
                    ->is('center')
                    ->is('small')
                    ->with('title', trans('Liitu Trip.ee reisihuviliste seltskonnaga'))
                )
            )

            ->with('content_top', component('Grid3')->with('items', collect()
                ->push(component('AuthTab')
                    ->with('title', 'E-mailiga')
                )
                ->push(component('AuthTab')
                    ->is('facebook')
                    ->with('title', 'Facebook')
                )
                ->push(component('AuthTab')
                    ->is('google')
                    ->with('title', 'Google')
                )
            ))

            ->with('content', collect()
                ->push(component('Form')->with('fields', collect()
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'Kasutajanimi')
                    )
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'E-mail')
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', 'Parool')
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', 'Parool uuesti')
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->with('title', 'Registreeri')
                    )
                ))
            )

            ->with('bottom', collect()->push(component('MetaLink')
                ->with('title', 'Trip.ee keskkonnaga liitudes nõustun ma kasutajatingimustega')
            ))

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function passwordForm()
    {
        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', 'Ei mäleta oma parooli?')
                )
                ->push('&nbsp;')
                ->push(component('Title')
                    ->is('center')
                    ->is('small')
                    ->with('title', 'Sisesta oma e-mail ja me saadame sulle kinnituslingi')
                )
            )

            ->with('content', collect()
                ->push(component('Form')->with('fields', collect()
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'Sinu e-post')
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->with('title', 'Saada')
                    )
                ))
            )

            ->with('bottom', collect()->push(component('MetaLink')
                ->with('title', 'Tuli meelde? Logi sisse siit.')
            ))

            ->with('footer', region('FooterLight'))

            ->render();
    }
<<<<<<< HEAD

    public function resetForm()
    {
        return layout('1colnarrow')
            ->with('color', 'gray')
            ->with('background', component('BackgroundMap'))
            ->with('header', region('StaticHeader'))

            ->with('top', collect()
                ->push(component('Title')
                    ->is('center')
                    ->is('large')
                    ->with('title', 'Vali uus parool')
                )
            )

            ->with('content', collect()
                ->push(component('Form')->with('fields', collect()
                    ->push(component('FormTextfield')
                        ->is('large')
                        ->with('title', 'Sinu e-post')
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', 'Uus parool')
                    )
                    ->push(component('FormPassword')
                        ->is('large')
                        ->with('title', 'Korda parooli')
                    )
                    ->push(component('FormButton')
                        ->is('wide')
                        ->with('title', 'Kinnita')
                    )
                ))
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

}
