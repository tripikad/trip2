...

## Installation

### Start

It's recommended to use Laravel Valet for development. Follow its instructions. https://laravel.com/docs/master/valet

Your will also need Yarn https://yarnpkg.com/en/docs/install

Then:

```sh
git clone https://github.com/tripikad/trip2
cd trip2
composer install
cp .env.example .env
php artisan key:generate
yarn
gulp
gulp v1 # to build legacy assets
```

### Databases

```
mysqladmin -uroot create trip
mysqladmin -uroot create trip2
```

Optionally use https://www.sequelpro.com to set up the databases. Ask for access to staging server to get the latest `trip2` database dump and migrate the data over, either using Sequel Pro or running

```
mysql -uroot trip2 < dump.sql
```

### What about npm?

If you still want to use npm, run:

```
npm install --no-optional
```

### Getting production images

In your `.env` file set the following parameter:

```
IMAGE_PATH=http://trip.ee/images/
```

### Redis

To get production-level caching experience, install Redis using Homebrew and then
add this to `.env` files:

```
CACHE_DRIVER=redis
PERMANENT_CACHE_DRIVER=redis
```

### Nginx cache

To test the local reverse proxy cache, edit `/usr/local/etc/nginx/valet/valet.conf` file:

1. Add the following to the top of the file:

```nginx
fastcgi_cache_path /tmp/nginx levels=1:2 keys_zone=TRIP2:256m inactive=60m use_temp_path=off; 
fastcgi_cache_key "$scheme$request_method$host$request_uri";
```

2. After the

```
fastcgi_param SCRIPT_FILENAME /.../
```

line add the following:

```nginx
fastcgi_cache TRIP2;
fastcgi_ignore_headers Set-Cookie; 
fastcgi_hide_header Set-Cookie;
fastcgi_pass_header Set-Cookie;
fastcgi_cache_bypass $cookie_logged $is_args;
fastcgi_no_cache $cookie_logged $is_args;
add_header X-Cache $upstream_cache_status;
```

and then run

```
valet restart
```

To clear the cache, run

```
rm -R /tmp/nginx/*
valet restart
```

## Development

### Watching frontend assets

At the time of writing, gulp watching does not work. Its reccomended to use `watch` utility, you will need to run:

```
brew install watch
watch gulp
```

### Testing

```
./vendor/bin/phpunit
```

### Linting

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
* https://youtrack.jetbrains.com/issue/WEB-19737#comment=27-1744895

## Frontend architecture

### Components

#### API

Components are located at ```resources/views/v2/components``` and are either Blade or Vue components.

To show a component use a ```component()``` helper:

```php
component('MyComponent')
    ->is('small') // Optional CSS modifier, adds a MyComponent--small class
    ->is('red') // Modifiers can be chained
    ->with('data1', 'Hello') // Passing a variable, similar to view()->with()
    ->with('data2', 'World') // Variables can be chained
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

#### CSS

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

Most of CSS properties use PostCSS variablest that can be found at `resources/views/v2/styles/variables.css`.

### Regions

#### API

Regions are located at ```app/Http/Regions``` and are simple PHP classes to extract rendering specific code chunks out of controllers.


To show a component use a ```region()``` helper:

```php
region('MyComponent', $parameter1, $parameter2) // etc
```

#### Making a region

To make a region, run

```sh
php artisan make:region MyRegion
```

and follow the directions.


### Layouts

#### API

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

#### CSS

There is no dedicated CSS files for layouts but you can use helper classes found in `resources/views/v2/styles/` folder.

#### Making a layout

At the time of writing there is no helper command to create a layout.

