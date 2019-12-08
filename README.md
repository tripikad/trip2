## Installation.

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
php artisan dusk:update --detect
yarn # or npm install
npm run dev
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

### Getting production images

In your `.env` file set the following parameter:

```
IMAGE_PATH=https://trip.ee/images/
```

### Redis

To get production-level caching experience, install Redis using Homebrew and then
add this to `.env` files:

```
CACHE_DRIVER=redis
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

## Testing

### Preparation

1. Make sure you use latest Chrome.

2. Run

    ```
    php artisan dusk:update
    ```

    If you want to run Dusk tests with previous version of Chrome you will need specify a version of Dusk update. Read more here https://github.com/staudenmeir/dusk-updater

3. Make sure the `FULL_BASE_URL` in `.env` file points to the local Laravel URL of your development environment

### Running all tests

```
npm run test
```

### Running feature and browser tests separately

```
./vendor/bin/phpunit
php artisan dusk
```

## Frontend development

### NPM commands

First make sure `FULL_BASE_URL` refers to local development URL.

```sh
npm run dev # runs watch + live
npm run watch # Unminified and fast dev build, recompiling on file change
npm run live # Live reload in browser
npm run devbuild # Unminified and fast dev build
npm run build # Minified and slow production build
```

### Build process

The main entrypoint is `./resources/views/main.js` what boots up a Vue instance and includes all the neccessary assets.

#### JS

Vue components from

```
./resources/views/components/**/*.vue
```

are compiled and minified to

```
./public/dist/main.hash.js
```

### Lazy component loading

Vue components can also be lazy-loaded, most useful for components that have large dependecies.

```vue
<template>
    // ...
    <component :is="'Editor'" />
</template>
<script>
export default {
  components: {
    Editor: () =>
      import("../../components_lazy/Editor/Editor.vue")
  },
// ...
```

This creates an extra packages `main.0.hash.js`, `main.1.hash.js` etc which are loaded on demand via ajax when `Editor` component is on the page.

#### CSS

Components CSS from

```
./resources/views/components/**/*.css
```

and helper CSS from

```
./resources/views/styles/**/*.css
```

are concatted, processed using PostCSS (the configuration is at `./postcss.config.js`) and saved to

```
./public/dist/main.hash.css
```

#### SVG

SVGs from `./resources/views/svg/**/*.svg`

are concat into a SVG sprite, optimized, minified and saved to

`./public/dist/main.svg`

## Frontend architecture: Components

### API

Components are located at `resources/views/components` and are either Laravel Blade or VueJS components.

To show a component use a `component()` helper:

```php
component('MyComponent')
    ->is('small') // Optional CSS modifier, adds a MyComponent--small class
    ->is('red') // Modifiers can be chained
    ->with('data1', 'Hello') // Passing a variable, similar to view()->with()
    ->with('data2', 'World'); // Variables can be chained
```

If there are both Blade and Vue components with the same name, Blade is preferred. You can request a Vue template by chaining a `->vue()` method.

### Making a component

To make a Blade component, run

```sh
php artisan make:component MyComponent
```

and follow the directions.

To make a Vue component run

```sh
php artisan make:component MyComponent --vue
```

### Component CSS

#### Class naming conventions

We use a hybrid BEM / SUIT naming
convention:

Blocks:

```css
.Component {
}
.AnotherComponent {
}
```

Elements (note the spacing):

```css
.Component__element {
}
.AnotherComponent__anotherElement {
}
```

Modifiers

```css
.Component--modifier {
}
.AnotherComponent--anotherModifier {
}
```

#### Style variables in CSS

Variables are located in `/resources/views/styles/styles.js`

For CSS, the variables are automatically available:

```scss
.Component {
    height: $spacer;
}
```

#### Style variables in PHP

Variables in `/resources/views/styles/styles.js` are exported to `config/styles.php` during fontent build time and can can be used in PHP files and Blade templates using `styles()` helper:

```blade
<div style="height: {{ styles('spacer') }}">
```

#### Style variables in Vue

Variables in `/resources/views/styles/variables.json` can be used in Vue templates like this:

```vue
<div :style="{ height: $styles.spacer }">
```

and in methods like this

```js
this.$styles.spacer
```

#### Fonts

##### Fonts for headings

Use the `$font-heading-xs | $font-heading-sm | $font-heading-md | $font-heading-lg | $font-heading-xl | $font-heading-xxl | $font-heading-xxxl` variables that set most of the font details.

Also, it's recommended to reduce contrast and use lighter font colors:

```scss
.Component__title {
    font: $font-heading-lg;
    color: $gray-dark;
}
```

##### Fonts for shorter plain texts

Use the `$font-text-xs | $font-text-sm | $font-text-md | $font-text-lg` variables.

```scss
.Component__description {
    font: $font-text-md; // The recommended body size
    color: $gray-dark; // For reduced contrast
}
```

##### Fonts for longer texts with markup

Use the dedicated `Body` component:

```php
component('Body')->with('body', $your_html_content);
```

#### Third party CSS

When using third party libraries one can import it's CSS from node_modules directory:

```scss
@import 'somelibrary/dist/somelibrary.css';
```

### Regions

#### API

Regions are located at `app/Http/Regions` and are simple PHP classes to extract rendering specific code chunks out of controllers.

To show a component use a `region()` helper:

```php
region('MyComponent', $parameter1, $parameter2); // etc
```

#### Making a region

To make a region, run

```sh
php artisan make:region MyRegion
```

and follow the directions.

### Layouts

#### API

Layouts are located at `resources/views/layouts` and are simple wrappers around top-level `view()`.

To show a component use a `layout()` helper:

```php
layout('One')
    ->with('data1', 'Hello') // Passing a variable
    ->with('data2', 'World') // Variables can be chained
    ->render(); // At the time of writing the final render() is required
```

By default layout() adds HTTP cache headers for 10 minutes. To disable this, add

```php
layout('One')->cached(false);
```

#### Making a layout

At the time of writing there is no helper command to create a layout .

## Backend arcitecture

### Models

See the [PR](pull/1934) for entity-relationship diagram:

[graph.png](https://github.com/tripikad/trip2/blob/96e4c22fca273759990300a8a52a217d7607a57a/graph.png?raw=true)
