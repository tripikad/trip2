## About 

Trip.ee codebase

## Installation

It's recommended to use Vagrant machine for development. See https://github.com/tripikad/trip2_vagrant/blob/master/README.md

## Testing

```
./vendor/bin/phpunit
```

## Linting

Run:

```sh
npm run test
```

### Sublime Text linters

* https://packagecontrol.io/packages/SublimeLinter
* https://packagecontrol.io/packages/SublimeLinter-contrib-eslint
* https://packagecontrol.io/packages/ESLint-Formatter
* https://packagecontrol.io/packages/SublimeLinter-contrib-stylelint
* https://github.com/morishitter/stylefmt

### PHPStorm linters

* https://www.jetbrains.com/help/phpstorm/10.0/eslint.html
* No Stylelint support yet, see https://youtrack.jetbrains.com/issue/WEB-19737

## Frontend architecture

### Components

#### API

Components are located at ```resources/views/v2/components``` and are either Blade or Vue components.

To show a component use a ```component()``` helper:

```php
component('MyComponent')
    ->is('small') // Optional CSS modifier, adds a MyComponent--small class
    ->with('data1', 'Hello') // Passing a variable, similar to view()->with()
    ->with('data2', 'World') // Variables can be chained
    ->show($request->user()) // Optional condition whenever to show component or not
```

#### Making a component

To make a Blade component, run

```sh
php artisan make:component MyComponent
```

and follow the directions.

To make a Vue component run

```sh
php artisan make:component MyComponent --vue
```

#### CSS conventions

We use PostCSS with [small set of plugins](https://github.com/tripikad/trip2/blob/master/elixir/postcss.js#L17) and use a hybrid BEM / SUIT convention:

Blocks:

```css
.Component {}
.AnotherComponent {}
```

Elements:

```css
.Component__element {}
.AnotherComponent__anotherElement {}
```

Modifiers:

```css
.Component--modifier {}
.AnotherComponent--anotherModifier {}
```


