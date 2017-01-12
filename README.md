### Installation

It's recommended to use Laravel Valet for development.

#### Redis

To get production-level caching experience, install Redis using Homebrew and then
add this to `.env` files:

```
CACHE_DRIVER=redis
PERMANENT_CACHE_DRIVER=redis
```
#### Getting production database

Ask for access to staging server to get the latest database dump.

#### Getting production images

In your `.env` file set the following parameter:

```
IMAGE_PATH=http://trip.ee/images/
```

### Development

#### CSS and JS

Run

```
gulp
```

At the time of writing, gulp watching does not work. Its reccomended to use `watch` utility, it's installed in Linux, in Mac you need to run:

```
brew install watch
watch gulp
```

#### Testing

```
./vendor/bin/phpunit
```

#### Linting

Run:

```sh
npm run test
```

#### Sublime Text linters

* https://packagecontrol.io/packages/SublimeLinter
* https://packagecontrol.io/packages/SublimeLinter-contrib-eslint
* https://packagecontrol.io/packages/ESLint-Formatter
* https://packagecontrol.io/packages/SublimeLinter-contrib-stylelint
* https://github.com/morishitter/stylefmt

#### PHPStorm linters

* https://www.jetbrains.com/help/phpstorm/10.0/eslint.html
* https://youtrack.jetbrains.com/issue/WEB-19737#comment=27-1744895

### Frontend architecture

#### Components

##### API

Components are located at ```resources/views/v2/components``` and are either Blade or Vue components.

To show a component use a ```component()``` helper:

```php
component('MyComponent')
    ->is('small') // Optional CSS modifier, adds a MyComponent--small class
    ->with('data1', 'Hello') // Passing a variable, similar to view()->with()
    ->with('data2', 'World') // Variables can be chained
```

##### Making a component

To make a Blade component, run

```sh
php artisan make:component MyComponent
```

and follow the directions.

To make a Vue component run

```sh
php artisan make:component MyComponent --vue
```

##### CSS conventions

We use PostCSS with [small set of plugins](https://github.com/tripikad/trip2/blob/master/elixir/postcss.js#L17) and use a hybrid BEM / SUIT naming 
convention:

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

#### Regions

##### API

Regions are located at ```app/Http/Regions``` and are simple PHP classes to extract rendering specific code chunks out of controllers.


To show a component use a ```region()``` helper:

```php
region('MyComponent', $parameter1, $parameter2) // etc
```

##### Making a region

To make a region, run

```sh
php artisan make:region MyRegion
```

and follow the directions.


#### Layouts

##### API

Layouts are located at ```resources/views/v2/layouts``` and are simple wrappers around top-level ```view()```.

To show a component use a ```layout()``` helper:

```php
layout('1col')
    ->with('data1', 'Hello') // Passing a variable
    ->with('data2', 'World') // Variables can be chained
    ->render() // At the time of writing the final render() is required
```

By default layout() adds HTTP cache headers for 10 minutes. To disable this, add

```php
layout('1col')
    ->cached(false)
```