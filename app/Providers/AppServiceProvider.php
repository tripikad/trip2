<?php

namespace App\Providers;

use Analytics;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Guard $auth)
    {
        $this->google_analytics_track($auth);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Carbon::setLocale(config('app.locale'));

        Collection::macro('render', function ($callback = false) {
            $renderable = $this;

            if ($callback) {
                $renderable = $this->map($callback);
            }

            return $renderable->map(function ($item) {
                return (string) $item;
            });
        });

        Collection::macro('withoutLast', function () {
            return $this->slice(0, $this->count() - 1);
        });

        Collection::macro('onlyLast', function ($count = 1) {
            return $this->reverse()
                ->slice(0, $count)
                ->reverse();
        });

        Collection::macro('withoutLastWhenOdd', function () {
            return $this->count() % 2 > 0 ? $this->withoutLast() : $this;
        });

        Collection::macro('withoutFirst', function () {
            return $this->slice(1, $this->count());
        });

        Collection::macro('pushWhen', function ($condition, $item) {
            if ($condition) {
                $this->push($item);
            }

            return $this;
        });

        Collection::macro('putWhen', function ($condition, $key, $item) {
            if ($condition) {
                $this->put($key, $item);
            }

            return $this;
        });

        Collection::macro('mergeWhen', function ($condition, $items) {
            if ($condition) {
                $this->merge($items);
            }

            return $this;
        });

        Collection::macro('br', function ($count = 1) {
            return $this->merge(collect(array_fill(0, $count, '<br />')));
            return $this;
        });

        Collection::macro('spacer', function ($value = 1) {
            return $this->push('<div style="height: ' . spacer($value) . ';"></div>');
            return $this;
        });

        Collection::macro('fill', function ($value = 1) {
            return $this->push('<div style="flex: 1;"></div>');
            return $this;
        });

        // https://adamwathan.me/2016/04/06/cleaning-up-form-input-with-transpose
        Collection::macro('transpose', function () {
            $items = array_map(function (...$items) {
                return $items;
            }, ...$this->values());

            return new static($items);
        });

        Collection::macro('fromPairs', function () {
            return $this->reduce(function ($assoc, $item) {
                [$key, $value] = $item;
                $assoc[$key] = $value;
                return $assoc;
            });
        });
    }

    protected function google_analytics_track($auth)
    {
        view()->composer('layouts.main', function () use ($auth) {
            if ($auth->check()) {
                Analytics::setUserId($auth->user()->id);
                Analytics::trackCustom("ga('set', 'user_role', '" . $auth->user()->role . "');");
            }
        });
    }
}
